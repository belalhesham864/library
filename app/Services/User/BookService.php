<?php

namespace App\Services\User;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Repositories\User\BookRepository;

class BookService
{
  public function __construct(private BookRepository $bookRepository) {}
  public function index()
  {
    return $this->bookRepository->index();
  }
  public function show($id)
  {
    return $this->bookRepository->show($id);
  }
}
