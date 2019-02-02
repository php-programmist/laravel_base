<?php

namespace App\Helpers;

use Intervention\Image\Facades\Image;

class ImageHelper
{
    /**
     * @param $file
     *
     * @param $path
     *
     * @return string
     */
    public static function uploadImage($file, $path): string
    {
        $image_name = str_random(6) . '_' . $file->getClientOriginalName();
        
        if ( ! file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, true);
        }
        $file->move(public_path($path), $image_name);
        $image_info       = getimagesize(public_path($path) . '/' . $image_name);
        $max_image_width  = config('settings.max_image_width', 750);
        $max_image_height = config('settings.max_image_height', 300);
        
        if ($image_info[0] > $max_image_width OR $image_info[1] > $max_image_height) {
            try{
                $image = Image::make(public_path($path) . '/' . $image_name);
                $image->fit($max_image_width, $max_image_height, function ($constraint) {
                    $constraint->upsize();
                });
                $image->save(public_path($path) . '/' . $image_name);
            } catch (\Exception $e){
                \Session::flash('error', __('system.image_resize_error') . "<br>" . $e->getMessage());
                
                return '';
            }
        }
        
        return $image_name;
    }
    
}