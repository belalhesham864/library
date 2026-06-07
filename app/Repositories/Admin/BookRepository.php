<?php

namespace App\Repositories\Admin;

use App\Models\Book;

class BookRepository{
    
    public function index(){
     return   Book::with('category')->active()->select('id', 'name', 'slug', 'category_id', 'cost', 'description', 'image', 'status')
            ->activeCategry()
            ->paginate(10);
    }
    public function store($data){
        return  Book::create($data);
    }
    public function show($id){
        return  Book::with('category')->find($id);
    } 
    public function find($id){
        return Book::find($id);
    }
    public function update($book,$data){
        $book->update($data);
    return $book;
    }

    public function destroy($book){
        return  $book->forceDelete();
    }
    public function delete($book){
        return  $book->delete();
    }
    public function findTrashed($id){
        return Book::withTrashed()->find($id);
    }
     public function return($book){
          $book->restore();
          return $book;
    }
    
}