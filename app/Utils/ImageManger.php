<?php

namespace App\Utils;

use Illuminate\Support\Str;

Class ImageManger{
    public static function uploadImage($request,){
        
$image = $request->file('image');
            $filename = Str::uuid() . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('uploads/users', $filename, ['disk' => 'uploads']);
               return $path;
    }
    
}