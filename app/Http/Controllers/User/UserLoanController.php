<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoanCollection;
use App\Http\Resources\LoanResource;
use App\Models\Book;
use App\Models\Loans;
use Illuminate\Http\Request;

class UserLoanController extends Controller
{
    public function index()
    {
        $loans = Loans::where('user_id', request()->user()->id)
            ->select('id', 'user_id', 'book_id', 'due_date', 'loans_at', 'returned_at')->paginate(10);
        if ($loans->isEmpty()) {
            return apiResponse(404, 'No Loans Found');
        } else {
            return apiResponse(200, 'My Loans', (new LoanCollection($loans))->response()->getData());
        }
    }


    public function store(Request $request)
    {
        $book_id=$request->book_id;
        $user = request()->user();
        $book = Book::find($book_id);
        if (!$book) {
            return apiResponse(404, 'Not Found');
        }
        if ($book->quantity < 1) {
            return apiResponse(400, 'the Book Not Available Now');
        }
        $userloaned = Loans::where('book_id', $book_id)->where('user_id', $user->id)->whereNull('returned_at')->exists();
        if ($userloaned) {
            return apiResponse(400, 'You Already Have This Book');
        }
        $loan=Loans::create([
            'user_id'=>$user->id,
            'book_id'=>$book_id,
            'loans_at'=>now(),
            'due_date'=>$request->due_date
        ]);
                $book->decrement('quantity');
  return apiResponse(201, 'Book Loaned Successfully', new LoanResource($loan));
    }
        public function return($id)
    {
        $user = request()->user();

        $loan = Loans::where('id', $id)->where('user_id', $user->id)->whereNull('returned_at')->first();

        if (!$loan) {
            return apiResponse(404, 'Loan Not Found or Already Returned');
        }

  
        $loan->update(['returned_at' => now()]);

        
        $loan->book->increment('quantity');

        return apiResponse(200, 'Book Returned Successfully', new LoanResource($loan->fresh()->load('book')));
    }
}


