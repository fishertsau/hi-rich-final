<?php

namespace App\Http\Controllers\admin;


use App\Models\Sample;
use App\Http\Controllers\Controller;

class SamplesController extends Controller
{

   public function index()
    {
        $samples = Sample::orderByRanking()->paginate(20);
        return view('system.sample.index', compact('samples'));
    }

    public function edit($id)
    {
        $sample = Sample::findOrFail($id);
        return view('system.sample.edit', compact('sample'));
    }

    public function create()
    {
        return view('system.sample.edit');
    }

    public function store()
    {
        $this->validateInput();

        $sample = Sample::create(request()->only(['published', 'title', 'body', 'description']));

        $this->storeCoverPhoto($sample);


        return redirect('admin/samples');
    }

    public function update(Sample $sample)
    {
        $this->validateInput();

        $sample->update(request()->only(['published', 'title', 'body', 'description']));

        $this->updatePhoto($sample);

        return redirect('admin/samples');
    }

    private function validateInput()
    {
        $this->validate(request(), [
            'title' => 'required',
            'published' => 'required|boolean'
        ]);
    }

    public function copy(Sample $sample)
    {
        $sample->title .= '(複製)';
        $sample->created_at = null;
        $copySample = true;
        return view('system.sample.edit', compact('sample', 'copySample'));
    }


    public function ranking()
    {
        collect(request('id'))->each(function ($id, $key) {
            Sample::findOrFail($id)
                ->update(['ranking' => request('ranking')[$key]]);
        });

        return redirect('admin/samples');
    }


    public function destroy(Sample $sample)
    {
        $sample->delete();

        return redirect('admin/samples');
    }

    public function action()
    {
        if (request('action') === 'setToShow') {
            collect(request('chosen_id'))->each(function ($id) {
                Sample::findOrFail($id)
                    ->update(['published' => true]);
            });
        }

        if (request('action') === 'setToNoShow') {
            collect(request('chosen_id'))->each(function ($id) {
                Sample::findOrFail($id)
                    ->update(['published' => false]);
            });
        }

        if (request('action') === 'delete') {
            collect(request('chosen_id'))->each(function ($id, $key) {
                Sample::findOrFail($id)
                    ->delete();
            });
        }

        return response(200);
    }


    private function storeCoverPhoto($sample)
    {
        if (request('photoCtrl') === 'newFile') {
            $sample->update(['photoPath' =>
                request()->file('photo')->store('images', 'public')]);
        }

        return $this;
    }

    private function updatePhoto($sample)
    {
        if (request('photoCtrl') === 'newFile') {
            $this->deleteFile($sample->photoPath);
            $sample->update(['photoPath' =>
                request()->file('photo')->store('images', 'public')]);
        }

        if (request('photoCtrl') === 'deleteFile') {
            $this->deleteFile($sample->photoPath);
            $sample->update(['photoPath' => null]);
        }

        return $this;
    }

    private function deleteFile($path)
    {
        \File::delete(public_path('storage') . '/' . $path);
    }
}