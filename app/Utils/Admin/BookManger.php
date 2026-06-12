<?php

namespace App\Utils\Admin;

use App\Models\Book;
use App\Utils\ImageManger;
use Illuminate\Support\Str;

class BookManger
{
   public static function store($request){
    $data=$request->validated();
    $data['image']=ImageManger::uploadImage($request,'uploads/books');
            $data['slug'] = Str::slug($data['name']);
                    $data['pdf']= $request->file('pdf')->store('uploads','public');

return Book::create($data);

   }
}
