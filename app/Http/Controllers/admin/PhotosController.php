<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Repositories\PhotoRepository;

class PhotosController extends Controller
{
    private $photoRepo;

    /**
     * PhotosController constructor.
     * @param $photoRepo
     */
    public function __construct(PhotoRepository $photoRepo)
    {
        $this->photoRepo = $photoRepo;
    }


    public function ckeditorUpload()
    {
        $photoPath = request()->file('upload')->store('ckeditorUpload', 'public');
        $file = url('/storage/' . $photoPath);

        return "<script type='text/javascript'>

        function getUrlParam(paramName) {
            var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
            var match = window.location.search.match(reParam);
            return ( match && match.length > 1 ) ? match[1] : null;
        }

        var funcNum = getUrlParam('CKEditorFuncNum');

        var par = window.parent,
            op = window.opener,
            o = (par && par.CKEDITOR) ? par : ((op && op.CKEDITOR) ? op : false);

        if (op) window.close();
        if (o !== false) o.CKEDITOR.tools.callFunction(funcNum, '$file');
        </script>";
    }

    public function summerNoteUpload()
    {
        return request()->file('image')->store('summernoteUpload', 'public');
    }

    public function destroy($filename)
    {
        $this->photoRepo->delete($filename);

        return response()->json([
            'status' => 'success',
            'message' => 'a photo is deleted successfully'
        ]);
    }


    public function update($filename)
    {
        $this->photoRepo->update($filename, ['title' => request('title')]);

        return response()->json([
            'status' => 'success',
            'message' => 'a photo title is updated successfully'
        ]);
    }
}
