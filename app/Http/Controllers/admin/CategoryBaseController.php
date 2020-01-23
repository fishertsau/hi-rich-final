<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Repositories\PhotoRepository;

abstract class CategoriesBaseController extends Controller
{
    use PhotoHandler;
    
    private $photoRepo;

    protected $indexPageUri;

    abstract protected function baseViewPath();
    
    protected $appliedCategory;

    /**
     * ProductCategoriesController constructor.
     * @param PhotoRepository $photoRepo
     */
    public function __construct(PhotoRepository $photoRepo)
    {
        $this->photoRepo = $photoRepo;
    }

    public function index()
    {
        $cats = $this->appliedCategory::main()->get();
        $nullParentSubCategories = $this->appliedCategory::whereLevel($this->appliedCategory::SECOND_LEVEL)->where('parent_id', null)->get();
        $nullParentSubSubCategories = $this->appliedCategory::whereLevel($this->appliedCategory::THIRD_LEVEL)->where('parent_id', null)->get();

        return view($this->baseViewPath().'.category.index',
            compact('cats', 'nullParentSubCategories', 'nullParentSubSubCategories'));
    }


    public function create()
    {
        if (request()->has('parentId')) {
            $parent = $this->appliedCategory::findOrFail(request('parentId'));
        }

        return view($this->baseViewPath().'.category.create', compact('parent'));
    }


    public function edit($id)
    {
        $category = $this->appliedCategory::find($id);
        
        $parent = $category->parentCategory;
        return view($this->baseViewPath().'.category.create', compact('category', 'parent'));
    }

    public function store()
    {
        $input = $this->getValidatedInput();

        $input['for'] = $this->appliedCategory::getCatIndex();

        if ($this->createForChildCategory()) {
            $this->createSubCategory($input);
            return redirect($this->indexPageUri);
        }

        $input = $this->generateLevelForFirstLevel($input);
        $category = $this->appliedCategory::create($input);
        $this->storePhoto($category);

        return redirect($this->indexPageUri);
    }


    public function update($id)
    {
        $category = $this->appliedCategory::findOrFail($id);

        $category->update($this->getValidatedInput());

        if (request()->has('parent_id')) {
            $this->updateParent($category);
        }

        $this->updatePhoto($category);

        return redirect($this->indexPageUri);
    }


    private function getValidatedInput()
    {
        return request()->validate([
            'activated' => 'required|boolean',
            'title' => '',
            'title_en' => '',
            'description' => '',
            'description_en' => ''
        ]);
    }

    public function destroy($id)
    {
        $this->appliedCategory::findOrFail($id)->delete();

        return redirect($this->indexPageUri);
    }

    public function ranking()
    {
        collect(request('id'))->each(function ($id, $key) {
            $this->appliedCategory::findOrFail($id)
                ->update(['ranking' => request('ranking')[$key]]);
        });

        return redirect($this->indexPageUri);
    }

    private function createSubCategory($input = [])
    {
        $parentCat = $this->appliedCategory::findOrFail(request('parent_id'));
        $input = $this->generateLevelForChild($input, $parentCat);

        $subCategory = $parentCat
            ->childCategories()
            ->create($input);

        $this->storePhoto($subCategory);
    }

    /**
     * @param $input
     * @param $parentCat
     * @return mixed
     */
    private function generateLevelForChild($input, $parentCat)
    {
        $input['level'] = $parentCat->level + 1;
        return $input;
    }

    /**
     * @return array|\Illuminate\Http\Request|string
     */
    private function createForChildCategory()
    {
        return request('parent_id');
    }

    /**
     * @param $input
     * @return mixed
     */
    private function generateLevelForFirstLevel($input)
    {
        $input['level'] = $this->appliedCategory::FIRST_LEVEL;
        return $input;
    }

    /**
     * @param $category
     */
    private function updateParent($category)
    {
        $category->update(['parent_id' => request('parent_id')]);
    }
}
