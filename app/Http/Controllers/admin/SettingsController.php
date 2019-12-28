<?php

namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use App\Models\WebConfig;

class SettingsController extends Controller
{
    public function siteFooter()
    {
        return view('system.settings.siteFooter');
    }

    public function password()
    {
        return view('system.settings.password');
    }

    public function pageInfo()
    {
        return view('system.settings.pageInfo');
    }

    public function googleMap()
    {
        return view('system.settings.googleMap');
    }

    public function mailService()
    {
        return view('system.settings.mailService');
    }

    public function updateMailService()
    {
        WebConfig::firstOrCreate()->update(request()->only(['mail_service_provider', 'mail_receivers']));

        return redirect('/admin/settings/mailService');
    }


    public function updateSiteFooter()
    {
        WebConfig::firstOrCreate()->update([
            'tel' => request('tel'),
            'fax' => request('fax'),
            'email' => request('email'),
            'email2' => request('email2'),
            'line_id' => request('line_id'),
            'blog_url' => request('blog_url'),
            'fb_url' => request('fb_url'),
            'pikebon_url' => request('pikebon_url'),
            'twitter_url' => request('twitter_url'),
            'google_plus_url' => request('google_plus_url'),
            'pinterest_url' => request('pinterest_url'),
            'youtube_url' => request('youtube_url'),
            'instagram_url' => request('instagram_url'),
            'declare' => request('declare'),
            'declare_en' => request('declare_en')
        ]);

        return redirect('/admin/settings/siteFooter');
    }

    public function updateGoogleMap()
    {
        WebConfig::firstOrCreate()->update([
            'address' => request('address'),
            'address_en' => request('address_en'),
            'address2' => request('address2'),
            'address2_en' => request('address2_en'),
        ]);

        return redirect('/admin/settings/googleMap');
    }

    public function updatePageInfo()
    {
        WebConfig::firstOrCreate()->update([
            'title' => request('title'),
            'keywords' => request('keywords'),
            'description' => request('description'),
            'meta' => request('meta'),
            'title_en' => request('title_en'),
            'keywords_en' => request('keywords_en'),
            'description_en' => request('description_en'),
            'meta_en' => request('meta_en')
        ]);

        return redirect('/admin/settings/pageInfo');
    }
}