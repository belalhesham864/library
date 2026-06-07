<?php

namespace App\Services\Admin;

use App\Repositories\Admin\BookRepository;
use App\Utils\ImageManger;
use Illuminate\Support\Str;
 
class BookService{
   public function __construct(private BookRepository $bookrepo){}

   public function index(){
   return $this->bookrepo->index();

   }
   public function store($data,$request){
       $data['image']=ImageManger::uploadImage($request,'uploads/books');
        $data['slug'] = Str::slug($data['name']);
   return $this->bookrepo->store($data);

   }

   public function show($id){
    return $this->bookrepo->show($id);
   }

   public function updated($request,$data,$id){
    $book=$this->bookrepo->find($id);
    if(!$book){
        throw new \Exception('Not Found',404);
    }
    if($request->hasFile('image')){
        $data['image']=ImageManger::update($request,$book,'uploads/books');
    }
    if(isset($data['name'])){
                $data['slug'] = Str::slug($data['name']);

    }
        return $this->bookrepo->update($book, $data);

   }

   public function destroy($id){
    $book=$this->bookrepo->find($id);
    if(!$book){
        throw new \Exception('Not Found',404);
    }
   ImageManger::delete($book);
    return $this->bookrepo->destroy($book);
   }

   public function archive($id){

    $book=$this->bookrepo->find($id);
  if(!$book){
        throw new \Exception('Not Found',404);
    }
    return $this->bookrepo->delete($book);
   }
   public function return($id){
    $book=$this->bookrepo->findTrashed($id);
    if(!$book){
        throw new \Exception('Not Found',404);
    }
        return $this->bookrepo->return($book);

   }
}