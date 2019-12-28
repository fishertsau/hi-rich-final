<?php

namespace App\Http\Controllers\admin;


use App\Models\Inquiry;
use App\Http\Controllers\Controller;
use App\Models\WebConfig;

class InquiriesController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::latest()->paginate(10);
        return view('system.inquiry.index', compact('inquiries'));
    }

    public function config()
    {
        return view('system.inquiry.config');
    }

    public function updateConfig()
    {
        WebConfig::firstOrCreate()->update(
            request()->only(['google_map', 'inquiry_info'])
        );
        return redirect('/admin/inquiries/config');
    }


    public function template()
    {
        return view('system.inquiry.template');
    }

    public function updateTemplate()
    {
        WebConfig::firstOrCreate()->update([
            'google_track_code' => request('google_track_code'),
            'inquiry_info' => request('inquiry_info'),
            'inquiry_info_en' => request('inquiry_info_en'),
        ]);

        return redirect('/admin/inquiries/template');
    }

    public function show($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        return view('system.inquiry.show', compact('inquiry'));
    }


    public function destroy($id)
    {
        Inquiry::findOrFail($id)->delete();

        return redirect('/admin/inquiries');
    }


    public function processed($id)
    {
        Inquiry::findOrFail($id)->update(['processed' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'An Inquiry is set to processed.']);
    }
}