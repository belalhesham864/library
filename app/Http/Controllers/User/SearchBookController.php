<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookCollection;
use App\Models\Book;
use Illuminate\Http\Request;

class SearchBookController extends Controller
{
    public function search(){
        $keyword=strip_tags(request()->keyword);
        $books=Book::active()->activeCategry()
        ->where('name','LIKE','%'.$keyword.'%')
        ->orWhere('description','LIKE','%'.$keyword.'%')
        ->orWhereHas('category',function($q) use ($keyword){
            $q->where('name','LIKE','%'.$keyword.'%');
        })->latest()
        ->paginate(10);
        if($books->isEmpty()){
            return apiResponse(404,'Not Found');
        }
        return apiResponse(200,'Books',(new BookCollection($books))->response()->getData());
    }
}
