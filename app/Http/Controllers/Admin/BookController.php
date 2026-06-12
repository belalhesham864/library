<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\Admin\BookService;
use App\Utils\Admin\BookManger;
use App\Utils\ImageManger;
use Illuminate\Support\Str;

class BookController extends Controller
{
 

       public function index()
    {
        $books =Book::with('category')->active()->select('id', 'name', 'slug', 'category_id', 'cost', 'description', 'image', 'status')
            ->activeCategry()
            ->paginate(10);
        if ($books->isEmpty()) {
            return apiResponse(404, 'Not Found');
        }
        return apiResponse(200, 'Active Book', (new BookCollection($books))->response()->getData());
    }

   
        public function store(BookRequest $request)
    {
        
   $book= BookManger::store($request);
        if (!$book) {
            return apiResponse(400, 'Please try again');
        }
        return apiResponse(201, 'Book Created Success', new BookResource($book));
    }


       public function show($id)
    {
        $book = Book::with('category')->find($id);

        if (!$book) {
            return apiResponse(404, 'Not Found');
        }
        return apiResponse(200, 'Success', new BookResource($book));
    }

   
    

public function update(UpdateBookRequest $request, $id)
{
        $data = $request->validated();
        $book=Book::find($id);
    if(!$book){
      return apiResponse(404,'Not Found');
    }
    if($request->hasFile('image')){
        $data['image']=ImageManger::update($request,$book,'uploads/books');
    }
    if(isset($data['name'])){
                $data['slug'] = Str::slug($data['name']);

    }
 $book->update($data);
        
        return apiResponse(200, 'Updated Successfully', new BookResource($book));
    
}

    /**
     * Remove the specified resource from storage.
     */
     public function destroy($id)
    {
     

 $book=Book::find($id);
    if(!$book){
         return apiResponse(404,'Not Found');
    }
   ImageManger::delete($book);
     $book->forceDelete();
                return apiResponse(200, 'Deleted Successfully');
           
        
    }


        public function archive($id)
    {
        

             $book=Book::find($id);
  if(!$book){
         return apiResponse(404,'Not Found');
    }
       $book->delete();
       return apiResponse(200, 'archived Successfully');
       }
            
    




        public function return($id)
    {
       
 $book=Book::onlyTrashed()->find($id);
    if(!$book){
         return apiResponse(404,'Not Found');
    }
         $book->restore();
                    return apiResponse(200, 'Book retutn Successfully', new BookResource($book));

        
    }
}
