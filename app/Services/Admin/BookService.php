<?php

namespace App\Services\Admin;

use App\Models\Book;
use App\Repositories\Admin\BookRepository;
use App\Utils\ImageManger;
use Illuminate\Support\Str;
 
class BookService{

   public function index(){
   return  Book::with('category')->active()->select('id', 'name', 'slug', 'category_id', 'cost', 'description', 'image', 'status')
            ->activeCategry()
            ->paginate(10);

   }
   public function store($data,$request){
       $data['image']=ImageManger::uploadImage($request,'uploads/books');
        $data['slug'] = Str::slug($data['name']);
   return Book::create($data);

   }

   public function show($id){
    return  Book::with('category')->find($id);
   }

   public function updated($request,$data,$id){
    $book=Book::find($id);
    if(!$book){
        throw new \Exception('Not Found',404);
    }
    if($request->hasFile('image')){
        $data['image']=ImageManger::update($request,$book,'uploads/books');
    }
    if(isset($data['name'])){
                $data['slug'] = Str::slug($data['name']);

    }
 $book->update($data);
    return $book;

   }

   public function destroy($id){
    $book=Book::find($id);
    if(!$book){
        throw new \Exception('Not Found',404);
    }
   ImageManger::delete($book);
    return $book->forceDelete();
   }

   public function archive($id){

    $book=Book::find($id);
  if(!$book){
        throw new \Exception('Not Found',404);
    }
    return   $book->delete();
   }
   public function return($id){
    $book=Book::onlyTrashed()->find($id);
    if(!$book){
        throw new \Exception('Not Found',404);
    }
         $book->restore();
          return $book;

   }
}