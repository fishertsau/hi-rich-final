<?php

namespace App\Presenter;


class TextStringPresenter
{
    public function truncateString($string, $length = 100)
    {
        if (strlen($string) <= $length) {
            return $string;
        }

        return substr($string, 0,$length) . ' ...';
    }

}