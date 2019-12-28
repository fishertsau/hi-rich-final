<?php

namespace App\Http\Controllers\admin;

use App;
use App\Models\Service;
use App\Models\WebConfig;
use App\Filterable\ServiceFilter;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\PhotoRepository;

class ServicesController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $catRepo;

    /**
     * @var PhotoRepository
     */
    private $photoRepo;


    /**
     * ServicesController constructor.
     * @param CategoryRepository $categoryRepository
     * @param PhotoRepository $photoRepo
     */
    public function __construct(CategoryRepository $categoryRepository, PhotoRepository $photoRepo)
    {
        $this->catRepo = $categoryRepository;

        $this->photoRepo = $photoRepo;
    }


    public function index()
    {
        $services = Service::orderByRanking()->paginate(20);

        return view('system.service.index', compact('services'));
    }

    public function edit(Service $service)
    {
        return view('system.service.create', compact('service'));
    }

    public function create()
    {
        return view('system.service.create');
    }

    public function config()
    {
        return view('system.service.config');
    }

    public function store()
    {
        $service = Service::create($this->validateInput());

        $this->storeCoverPhoto($service);

        return redirect('/admin/services');
    }


    public function update($id)
    {
        $service = Service::findOrFail($id);

        $service->update($this->validateInput());

        $this
            ->updateCoverPhoto($service);

        return redirect('/admin/services');
    }


    public function copy(Service $service)
    {
        $copyService = $service;
        $copyService->title .= '(複製)';

        if (config('app.english_enabled')) {
            $copyService->title_en .= '(複製)';
        }

        return view('system.service.create', compact('copyService'));
    }


    public function ranking()
    {
        collect(request('id'))->each(function ($id, $key) {
            Service::findOrFail($id)
                ->update(['ranking' => request('ranking')[$key]]);
        });

        return redirect('admin/services');
    }


    public function action()
    {
        if (request('action') === 'setToShowAtHome') {
            collect(request('chosen_id'))->each(function ($id) {
                Service::findOrFail($id)
                    ->update(['published_in_home' => true]);
            });
        }

        if (request('action') === 'setToNoShowAtHome') {
            collect(request('chosen_id'))->each(function ($id) {
                Service::findOrFail($id)
                    ->update(['published_in_home' => false]);
            });
        }

        if (request('action') === 'setToShow') {
            collect(request('chosen_id'))->each(function ($id) {
                Service::findOrFail($id)
                    ->update(['published' => true]);
            });
        }

        if (request('action') === 'setToNoShow') {
            collect(request('chosen_id'))->each(function ($id) {
                Service::findOrFail($id)
                    ->update(['published' => false]);
            });
        }

        if (request('action') === 'delete') {
            collect(request('chosen_id'))->each(function ($id, $key) {
                Service::findOrFail($id)
                    ->delete();
            });
        }

        return response(200);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect('admin/services');
    }

    private function validateInput()
    {
        return request()->validate([
            'published' => 'required|boolean',
            'published_in_home' => 'required|boolean',
            'title' => '',
            'title_en' => '',
            'body' => '',
            'body_en' => ''
        ]);
    }

    private function storeCoverPhoto($service)
    {
        if (request('photoCtrl') === 'newFile') {
            $service->update(['photoPath' =>
                $this->photoRepo->store(request()->file('photo'))
            ]);
        }

        return $this;
    }


    /**
     * @param $service
     */
    private function updateCoverPhoto($service)
    {
        if (request('photoCtrl') === 'newFile') {
            $this->deleteFile($service->photoPath);
            $service->update(['photoPath' =>
                $this->photoRepo->store(request()->file('photo'))
            ]);
        }

        if (request('photoCtrl') === 'deleteFile') {
            $this->deleteFile($service->photoPath);
            $service->update(['photoPath' => null]);
        }

        return $this;
    }


    private function deleteFile($path)
    {
        \File::delete(public_path('storage') . '/' . $path);
    }


    public function getPublishedInHome()
    {
        return Service::where('published_in_home', true)->get();
    }
}