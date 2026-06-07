<?php

namespace App\Repositories\User;

use App\Models\Book;


class BookRepository
{
    public function index()
    {
        return Book::select('id', 'name', 'slug', 'image', 'status', 'cost', 'description', 'category_id')
            ->active()->activeCategry()->paginate(10);
    }
    public function show($id)
    {
        return Book::select('id', 'name', 'slug', 'image', 'status', 'cost', 'description', 'category_id')
            ->active()->find($id);
    }
    public function find($id){
        return Book::find($id);
    }
}
