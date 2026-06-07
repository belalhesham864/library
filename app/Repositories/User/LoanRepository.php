<?php

namespace App\Repositories\User;

use App\Models\Loans;
use Illuminate\Support\Facades\DB;

class LoanRepository
{
    public function index($userId)
    {
        return Loans::where('user_id', $userId)
            ->select('id', 'user_id', 'book_id', 'due_date', 'loans_at', 'returned_at')->paginate(10);
    }
    public function userHasBook($bookId, $userId)
    {
        return Loans::where('book_id', $bookId)->where('user_id', $userId)->whereNull('returned_at')->exists();
    }
    public function store($data, $userId)
    {

        return DB::transaction(function () use ($data, $userId) {
            $loan = Loans::create([
                'user_id' => $userId,
                'book_id' => $data['book_id'],
                'loans_at' => now(),
                'due_date' => $data['due_date'],
            ]);
            $loan->book->decrement('quantity');
            return $loan;
        });
    }


    public function findLoan($id, $userId)
    {
        return Loans::where('id', $id)->where('user_id', $userId)->whereNull('returned_at')->first();
    }

    public function returnLoan(Loans $loan)
    {
        return DB::transaction(function () use ($loan) {
            $loan->update(['returned_at' => now()]);
            $loan->book->increment('quantity');
            return $loan;
        });
    }
}
