<?php

namespace App\Http\Controllers\admin;


use App\Models\WebConfig;
use App\Http\Controllers\Controller;
use App\Repositories\PhotoRepository;

class SettingsController extends Controller
{
    use PhotoHandler;

    private $photoRepo;

    /**
     * ProductsController constructor.
     * @param PhotoRepository $photoRepository
     */
    public function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepo = $photoRepository;
    }

    public function companyInfo()
    {
        return view('system.settings.companyInfo');
    }

    public function updateCompanyInfo()
    {
        WebConfig::firstOrCreate()->update([
            'company_name' => request('company_name'),
            'tel' => request('tel'),
            'fax' => request('fax'),
            'address' => request('address'),
            'email' => request('email'),
            'copyright_declare' => request('copyright_declare')
        ]);

        return redirect('/admin/settings/companyInfo');
    }


    public function marketingInfo()
    {
        return view('system.settings.marketingInfo');
    }

    public function updateMarketingInfo()
    {
        $webConfig = WebConfig::firstOrCreate();

        $webConfig->update([
            'slogan' => request('slogan'),
            'slogan_sub' => request('slogan_sub'),
            'product' => request('product'),
            'place' => request('place'),
            'location' => request('location'),
            'service_hour' => request('service_hour'),
        ]);

        $this->updatePhoto($webConfig);
        $this->updatePdfFile($webConfig);

        return redirect('/admin/settings/marketingInfo');
    }


    public function pageInfo()
    {
        return view('system.settings.pageInfo');
    }

    public function updatePageInfo()
    {
        WebConfig::firstOrCreate()->update([
            'title' => request('title'),
            'keywords' => request('keywords'),
            'description' => request('description'),
            'meta' => request('meta'),
        ]);

        return redirect('/admin/settings/pageInfo');
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

    public function password()
    {
        return view('system.settings.password');
    }

    private function updatePdfFile(WebConfig $model)
    {
        if (request('pdfCtrl') === 'newPdfFile') {
            $this->deleteFile($model->pdfPath);
            $model->update(['pdfPath' =>
                request()->file('pdfFile')->store('pdf', 'public')]);
        }

        if (request('pdfCtrl') === 'deletePdfFile') {
            $this->deleteFile($model->pdfPath);
            $model->update(['pdfPath' => null]);
        }

        return $this;
    }
}