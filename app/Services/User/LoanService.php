<?php

namespace App\Services\User;

use App\Models\Book;
use App\Models\Loans;
use App\Repositories\User\BookRepository;
use App\Repositories\User\LoanRepository;
use Illuminate\Support\Facades\DB;

class LoanService
{
    /**
     * Create a new class instance.
     */
    public function index($userId)
    {
        return Loans::where('user_id', $userId)
            ->select('id', 'user_id', 'book_id', 'due_date', 'loans_at', 'returned_at')->paginate(10);
    }
    public function store($data, $userId)
    {
        $book = Book::with('category')->find($data['book_id']);

        if (!$book) {
            throw new \Exception("Book Not Found", 404);
        }
        if ($book->quantity < 1) {
            throw new \Exception("Book Not Avaliable Now", 404);
        }
        if (Loans::where('book_id', $data['book_id'])->where('user_id', $userId)->whereNull('returned_at')->exists()) {
            throw new \Exception('You Already Have This Book', 400);
        }
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

    public function returnLoan($id, $userId)
    {
        $loan =   Loans::where('id', $id)->where('user_id', $userId)->whereNull('returned_at')->first();

        if (!$loan) {
            throw new \Exception('Not Found loan', 404);
        }
        return DB::transaction(function () use ($loan) {
            $loan->update(['returned_at' => now()]);
            $loan->book->increment('quantity');
            return $loan;
        });
    }
}
