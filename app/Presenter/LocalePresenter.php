<?php

namespace App\Presenter;


use App;

class LocalePresenter
{
    public function ChinesePostfix()
    {
        if (config('app.english_enabled')) {
            return '(中文)';
        }

        return '';
    }

    public function ChinesePrefix()
    {
        if (config('app.english_enabled')) {
            return '中文';
        }

        return '';
    }

    public function localeField($model, $field)
    {
        if(App::getLocale()==='en'){
            return $model->{"$field"."_en"};
        }
        return $model->{$field};
    }
}