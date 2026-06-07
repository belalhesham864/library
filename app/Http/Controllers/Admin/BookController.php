<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Book\BookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\Admin\BookService;
class BookController extends Controller
{
 
       public function __construct(private BookService $bookService){}

       public function index()
    {
        $books = $this->bookService->index();
        if ($books->isEmpty()) {
            return apiResponse(404, 'Not Found');
        }
        return apiResponse(200, 'Active Book', (new BookCollection($books))->response()->getData());
    }

   
        public function store(BookRequest $request)
    {
        $data = $request->validated();
        
        $book = $this->bookService->store($data,$request);
        if (!$book) {
            return apiResponse(400, 'Please try again');
        }
        return apiResponse(201, 'Book Created Success', new BookResource($book));
    }


       public function show($id)
    {
        $book = $this->bookService->show($id);

        if (!$book) {
            return apiResponse(404, 'Not Found');
        }
        return apiResponse(200, 'Success', new BookResource($book));
    }

   
    

public function update(UpdateBookRequest $request, $id)
{
    try {
        $data = $request->validated();
        $book = $this->bookService->updated($request, $data, $id);
        return apiResponse(200, 'Updated Successfully', new BookResource($book));
    } catch (\Exception $e) {
        return apiResponse($e->getCode(), $e->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     */
     public function destroy($id)
    {
        try{

          $this->bookService->destroy($id);
            return apiResponse(200, 'Deleted Successfully');
            }catch(\Exception $e){
                return apiResponse($e->getCode(),$e->getMessage());
            }
    }
        public function archive($id)
    {
          try{

          $this->bookService->archive($id);
            return apiResponse(200, 'archived Successfully');
            }catch(\Exception $e){
                return apiResponse($e->getCode(),$e->getMessage());
            }
    }
        public function return($id)
    {
       try{
      $book=$this->bookService->return($id);
           return apiResponse(200, 'Book retutn Successfully', new BookResource($book));
           }catch(\Exception $e){
                            return apiResponse($e->getCode(),$e->getMessage());

           }
    }
}
