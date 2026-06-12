<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\loans\LoanRequest;
use App\Http\Resources\LoanCollection;
use App\Http\Resources\LoanResource;
use App\Models\Book;
use App\Models\Loans;
use App\Models\reservations;
use App\Notifications\BookAvilableNotifaction;
use App\services\User\LoanServies;
use App\services\User\returnLoanServies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserLoanController extends Controller
{
    public function index()
    {
        $userId = request()->user()->id;

        $loans = Loans::where('user_id', $userId)
            ->select('id', 'user_id', 'book_id', 'due_date', 'loans_at', 'returned_at')->paginate(10);

        if ($loans->isEmpty()) {
            return apiResponse(404, 'No Loans Found');
        }
        return apiResponse(200, 'My Loans', (new LoanCollection($loans))->response()->getData());
    }





    public function store(LoanRequest $request, LoanServies $loan)
    {
        return $loan->loan($request);
    }




    public function return($id, returnLoanServies $loan)
    {
        return $loan->return($id);
    }






    public function download($id)
    {
        $loan = Loans::where('user_id', auth()->id())
            ->where('book_id', $id)
            ->first();
        if (!$loan) {
            return apiResponse(400, "must loan the book first");
        }
        $book = Book::find($id);

        return Storage::disk('public')->download($book->pdf);
    }
    public function reseve($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return apiResponse(404, 'Book Not Found');
        }
        if ($book->quantity > 1) {
            return apiResponse(400, 'Book is available , You can loans ');
        }
        $reseve = reservations::create([
            'book_id' => $book->id,
            'user_id' => auth()->id()
        ]);
        return apiResponse(201, "Book Reserved Successfully");
    }
    public function cancelreseve($id)
    {
        $resev = reservations::where('id', $id)->where('user_id', auth()->id())->whereIn('status', ['pending', 'available'])->first();

        if (!$resev) {
            return apiResponse(404, "Resever Not Found");
        }
        $resev->update(['status' => 'cancelled']);
        return apiResponse(200, " Reserved Cancled Successfully");
    }
}
