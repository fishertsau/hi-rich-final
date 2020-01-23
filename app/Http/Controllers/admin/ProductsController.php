<?php

namespace App\Http\Controllers\admin;

use App;
use App\Models\Product;
use App\Models\WebConfig;
use App\Filterable\ProductFilter;
use App\Http\Controllers\Controller;
use App\Repositories\PhotoRepository;
use App\Repositories\CategoryRepository;

class ProductsController extends Controller
{
    use PhotoHandler;

    /**
     * @var CategoryRepository
     */
    private $catRepo;

    private $photoRepo;

    /**
     * ProductsController constructor.
     * @param CategoryRepository $categoryRepository
     * @param PhotoRepository $photoRepository
     */
    public function __construct(CategoryRepository $categoryRepository, PhotoRepository $photoRepository)
    {
        $this->catRepo = $categoryRepository;
        $this->photoRepo = $photoRepository;
    }


    public function index()
    {
        return redirect('admin/products/list');
    }

    public function edit(Product $product)
    {
        return view('system.product.create', compact('product'));
    }

    public function create()
    {
        return view('system.product.create');
    }

    public function config()
    {
        return view('system.product.config');
    }

    public function store()
    {
        $product = Product::create($this->validateInput());

        $this->storeCoverPhoto($product);

        $this->storePdfFile($product);

        $this->storePhotos($product, request('photos'), request('photoTitles'));

        return redirect('/admin/products');
    }

    private function storePhotos(Product $product, $photos, $photoTitles)
    {
        collect($photos)->each(function ($photofile, $key) use ($product, $photoTitles) {
            if (!is_file($photofile)) {
                return;
            }

            $photoPath = $this->photoRepo->store($photofile);

            $product->photos()->create([
                'photoPath' => $photoPath,
                'title' => $photoTitles[$key]]);
        });
    }


    public function update($id)
    {
        $product = Product::findOrFail($id);

        $product->update($this->validateInput());

        $this->updatePhoto($product);
        
        $this->updatePdfFile($product)
            ->storePhotos($product, request('photos'), request('photoTitles'));

        return redirect('/admin/products');
    }


    public function copy(Product $product)
    {
        $copyProduct = $product;
        $copyProduct->title .= '(複製)';

        if (config('app.english_enabled')) {
            $copyProduct->title_en .= '(複製)';
        }

        return view('system.product.create', compact('copyProduct'));
    }


    public function ranking()
    {
        collect(request('id'))->each(function ($id, $key) {
            Product::findOrFail($id)
                ->update(['ranking' => request('ranking')[$key]]);
        });

        return redirect('admin/products');
    }


    public function action()
    {
        if (request('action') === 'setToShowAtHome') {
            collect(request('chosen_id'))->each(function ($id) {
                Product::findOrFail($id)
                    ->update(['published_in_home' => true]);
            });
        }

        if (request('action') === 'setToNoShowAtHome') {
            collect(request('chosen_id'))->each(function ($id) {
                Product::findOrFail($id)
                    ->update(['published_in_home' => false]);
            });
        }

        if (request('action') === 'setToShow') {
            collect(request('chosen_id'))->each(function ($id) {
                Product::findOrFail($id)
                    ->update(['published' => true]);
            });
        }

        if (request('action') === 'setToNoShow') {
            collect(request('chosen_id'))->each(function ($id) {
                Product::findOrFail($id)
                    ->update(['published' => false]);
            });
        }

        if (request('action') === 'delete') {
            collect(request('chosen_id'))->each(function ($id, $key) {
                Product::findOrFail($id)
                    ->delete();
            });
        }

        return response(200);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('admin/products');
    }

    private function validateInput()
    {
        return request()->validate([
            'published' => 'required|boolean',
            'published_in_home' => 'required|boolean',
            'cat_id' => '',
            'title' => '',
            'briefing' => '',
            'body' => '',
        ]);
    }

    public function updateConfig()
    {
        WebConfig::firstOrCreate()
            ->update(request()
                ->only(['product_show_per_page']));

        return redirect('admin/products');
    }

    public function getList()
    {
        $queryTerm = $this->getQueryTerm();

        $products = App::make(ProductFilter::class)->getList($queryTerm);
        return view('system.product.index', compact('products', 'queryTerm'));
    }

    private function getQueryTerm()
    {
        if (request()->has('newSearch')) {
            $queryTerm = $this->convertInputToQueryTerm();
            $this->saveQueryTermToSession($queryTerm);
            return $queryTerm;
        }

        return session('queryTerm');
    }

    /**
     * @return array
     */
    private function convertInputToQueryTerm()
    {
        $queryTerm = request()->only(['keyword', 'cat_id', 'published']);

        $queryTerm['published'] =
            isset($queryTerm['published'])
                ? (boolean)$queryTerm['published']
                : '';

        if (isset($queryTerm['cat_id'])) {
            $queryTerm['cat_ids'] = $this->catRepo->getSelfOrDescendantsId(request('cat_id'));
        }

        return $queryTerm;
    }

    /**
     * @param $queryTerm
     */
    private function saveQueryTermToSession($queryTerm)
    {
        session()->put('queryTerm', $queryTerm);
    }

    private function storePdfFile(Product $product)
    {
        if (request('pdfCtrl') === 'newPdfFile') {
            $product->update(['pdfPath' =>
                request()->file('pdfFile')->store('pdf', 'public')]);
        }
        return $this;
    }

    private function updatePdfFile(Product $product)
    {
        if (request('pdfCtrl') === 'newPdfFile') {
            $this->deleteFile($product->pdfPath);
            $product->update(['pdfPath' =>
                request()->file('pdfFile')->store('pdf', 'public')]);
        }

        if (request('pdfCtrl') === 'deletePdfFile') {
            $this->deleteFile($product->pdfPath);
            $product->update(['pdfPath' => null]);
        }

        return $this;
    }


    private function deleteFile($path)
    {
        \File::delete(public_path('storage') . '/' . $path);
    }


    public function getPublishedInHome()
    {
        return Product::where('published_in_home', true)->get();
    }
}