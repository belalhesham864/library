<?php

namespace App\Services\User;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Repositories\User\BookRepository;

class BookService
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
}
