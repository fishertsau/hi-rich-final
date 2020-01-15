<?php

namespace App\Http\Controllers\admin;


use App\Models\About;
use App\Http\Controllers\Controller;
use App\Repositories\PhotoRepository;

class AboutsController extends Controller
{
    /**
     * @var PhotoRepository
     */
    private $photoRepo;

    /**
     * ProductsController constructor.
     * @param PhotoRepository $photoRepository
     */
    public function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepo = $photoRepository;
    }

    public function index()
    {
        $abouts = About::orderByRanking()->paginate(20);

        return view('system.abouts.index', compact('abouts'));
    }

    public function edit($id)
    {
        $about = About::findOrFail($id);
        return view('system.abouts.edit', compact('about'));
    }

    public function create()
    {
        return view('system.abouts.edit');
    }

    public function store()
    {
        $input = $this->validateInput();
        $input['ranking'] = About::get()->count() + 1;

        $about = About::create($input);

        $this->storeCoverPhoto($about);

        return redirect('admin/abouts');
    }

    public function update(About $about)
    {
        $about->update($this->validateInput());

        $this->updatePhoto($about);

        return redirect('admin/abouts');
    }

    private function validateInput()
    {
        return request()->validate([
            'title' => '',
            'published' => 'required|boolean',
            'body' => '',
        ]);
    }

    public function copy(About $about)
    {
        $about->title .= '(複製)';
        $copy = true;

        return view('system.abouts.edit', compact('about', 'copy'));
    }


    public function ranking()
    {
        collect(request('id'))->each(function ($id, $key) {
            About::findOrFail($id)
                ->update(['ranking' => request('ranking')[$key]]);
        });

        return redirect('admin/abouts');
    }


    public function destroy(About $about)
    {
        $about->delete();

        return redirect('admin/abouts');
    }

    public function action()
    {
        if (request('action') === 'setToShow') {
            collect(request('chosen_id'))->each(function ($id) {
                About::findOrFail($id)
                    ->update(['published' => true]);
            });
        }

        if (request('action') === 'setToNoShow') {
            collect(request('chosen_id'))->each(function ($id) {
                About::findOrFail($id)
                    ->update(['published' => false]);
            });
        }

        if (request('action') === 'delete') {
            collect(request('chosen_id'))->each(function ($id, $key) {
                About::findOrFail($id)
                    ->delete();
            });
        }

        return response(200);
    }

    /**
     * @param $about
     * @return AboutsController
     */
    private function storeCoverPhoto($about)
    {
        if (request('photoCtrl') === 'newFile') {
            $about->update(['photoPath' =>
                $this->photoRepo->store(request()->file('photo'))
            ]);
        }

        return $this;
    }

    /**
     * @param $model
     * @return AboutsController
     */
    private function updatePhoto($model)
    {
        if (request('photoCtrl') === 'newFile') {
            $this->deleteFile($model->photoPath);
            $model->update(['photoPath' =>
                $this->photoRepo->store(request()->file('photo')),
            ]);
        }

        if (request('photoCtrl') === 'deleteFile') {
            $this->deleteFile($model->photoPath);
            $model->update(['photoPath' => null]);
        }

        return $this;
    }

    private function deleteFile($path)
    {
        \File::delete(public_path('storage') . '/' . $path);
    }
}