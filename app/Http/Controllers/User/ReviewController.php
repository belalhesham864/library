<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\ReviewRequest;
use App\Models\ReviewBook;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function review(ReviewRequest $request){
        $data=$request->validated();
        $exist=ReviewBook::where('user_id',auth()->id())->where('book_id',$data['book_id'])->exists();
        if($exist){
            return apiResponse(400,'You already Review the book');
        }
        $review=ReviewBook::create([
            'user_id'=>auth()->id(),
        'book_id'=>$data['book_id'],
        'rating'=>$data['rating'],
        'comment'=>$data['comment']??null
        ]);
            return apiResponse(201, 'Review added', $review);

    }
}
