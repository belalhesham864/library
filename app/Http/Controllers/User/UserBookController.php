<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookCollection;
use App\Models\Book;
use Illuminate\Http\Request;

class UserBookController extends Controller
{
    public function index(){
        $books=Book::select('id','name','slug','image','status','cost','description','category_id')
        ->active()->activeCategry()->paginate(10);

        if($books->isEmpty()){
            return apiResponse(404,'Not Found Books');
        }
        return apiResponse(200,'All Books',new BookCollection($books));
    }

    public function show($id){
        $book=Book::find($id);
        if(!$book){
             return apiResponse(404,'Not Found Book');
        }
          return apiResponse(200,'Book',new BookCollection($book));
    }
}
