<?php
/**
 * Created by PhpStorm.
 * User: КажиевС
 * Date: 28.04.2016
 * Time: 19:58
 */

namespace App\Http;


class Helper
{
    public static function select($options = [], $selected = 1, $first_option = '', $attrs = [])
    {
        return view('helpers.select')
            ->with('options', $options)
            ->with('selected', $selected)
            ->with('first_option',$first_option)
            ->with('attrs', $attrs);
    }
}