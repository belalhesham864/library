<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Services\User\BookService;
use Illuminate\Http\Request;

class UserBookController extends Controller
{


    public function __construct(private BookService $bookService) {}

    public function index()
    {
        $books = $this->bookService->index();
        if ($books->isEmpty()) {
            return apiResponse(404, 'Not Found Books');
        }
        return apiResponse(200, 'All Books', new BookCollection($books));
    }

    public function show($id)
    {
        $book = $this->bookService->show($id);
        if (!$book) {
            return apiResponse(404, 'Not Found Book');
        }
        return apiResponse(200, 'Book', new BookResource($book));
    }
}
