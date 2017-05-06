<?php

use App\Space\Settings\Setting;

/**
 * Set Active Path
 *
 * @param $path
 * @param string $active
 * @return string
 */
function set_active($path, $active = 'active') {

    return call_user_func_array('Request::is', (array)$path) ? $active : '';

}

/**
 * @param $path
 * @return mixed
 */
function is_url($path){
    return call_user_func_array('Request::is', (array)$path);
}

/**
 * @param $string
 * @return string
 */
function clean_slug($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return \Illuminate\Support\Str::lower(preg_replace('/[^A-Za-z0-9\-]/', '', $string)); // Removes special chars.
}

/**
 * @param $set
 * @return null
 */
function get_setting($set){

    $setting = Setting::whereOption($set)->first();

    if($setting){
        return $setting->value;
    }else{
        return null;
    }
}

/**
 * Files compiled with combine() are not included in Dev server.
 * To fix that, we can use asset() when the HOT Reload is ON
 *
 * @param $file
 * @return \Illuminate\Support\HtmlString|string
 */
function combine_mix($file){
    if(file_exists(public_path('hot'))){
        return asset($file);
    }
    
    return mix($file);
}