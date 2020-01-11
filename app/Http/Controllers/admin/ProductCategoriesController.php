<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Repositories\PhotoRepository;

class ProductCategoriesController extends Controller
{
    private $photoRepo;

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
        $cats = Category::whereLevel(Category::FIRST_LEVEL)->get();
        $nullParentSubCategories = Category::whereLevel(Category::SECOND_LEVEL)->where('parent_id', null)->get();
        $nullParentSubSubCategories = Category::whereLevel(Category::THIRD_LEVEL)->where('parent_id', null)->get();

        return view('system.product.category.index',
            compact('cats', 'nullParentSubCategories', 'nullParentSubSubCategories'));
    }


    public function create()
    {
        if (request()->has('parentId')) {
            $parent = Category::findOrFail(request('parentId'));
        }

        return view('system.product.category.create', compact('parent'));
    }


    public function edit(Category $category)
    {
        $parent = $category->parentCategory;
        return view('system.product.category.create', compact('category', 'parent'));
    }

    public function store()
    {
        $input = $this->getValidatedInput();

        if ($this->createForChildCategory()) {
            $this->createSubCategory($input);
            return redirect('/admin/product/categories');
        }

        $input = $this->generateLevelForFirstLevel($input);
        $category = Category::create($input);
        $this->storePhoto($category);

        return redirect('/admin/product/categories');
    }


    public function update($id)
    {
        $category = Category::findOrFail($id);

        $category->update($this->getValidatedInput());

        if (request()->has('parent_id')) {
            $this->updateParent($category);
        }

        $this->updatePhoto($category);

        return redirect('/admin/product/categories');
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
        Category::findOrFail($id)->delete();

        return redirect('/admin/product/categories');
    }


    public function ranking()
    {
        collect(request('id'))->each(function ($id, $key) {
            Category::findOrFail($id)
                ->update(['ranking' => request('ranking')[$key]]);
        });

        return redirect('/admin/product/categories');
    }

    /**
     * @param $category
     */
    private function storePhoto(Category $category)
    {
        if (request('photoCtrl') === 'newFile') {
            $category->update([
                'photoPath' => $this->photoRepo->store(request()->file('photo'))]);
        }
    }

    private function createSubCategory($input = [])
    {
        $parentCat = Category::findOrFail(request('parent_id'));
        $input = $this->generateLevelForChild($input, $parentCat);

        $subCategory = $parentCat
            ->childCategories()
            ->create($input);

        $this->storePhoto($subCategory);
    }

    /**
     * @param $category
     */
    private function updatePhoto($category)
    {
        if (request('photoCtrl') === 'newFile') {
            $this->photoRepo->deletePhotoFile($category->photoPath);
            $category->update(['photoPath' =>
                $this->photoRepo->store(request()->file('photo'))]);
        }

        if (request('photoCtrl') === 'deleteFile') {
            $this->photoRepo->deletePhotoFile($category->photoPath);
            $category->update(['photoPath' => null]);
        }
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
        $input['level'] = Category::FIRST_LEVEL;
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
