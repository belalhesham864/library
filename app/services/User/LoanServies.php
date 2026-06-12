<?php

namespace App\services\User;

use App\Http\Resources\LoanResource;
use App\Models\Book;
use App\Models\Loans;
use App\Models\reservations;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoanServies
{


    public function valditon($request)
    {
        $valditor = Validator::make($request->all(), $request->rules());
        if ($valditor->fails()) {
            throw new Exception($valditor->errors(), 422);
        }
        return $valditor->validated();
    }
    public function findBook($data)
    {
        $book = Book::with('category')->find($data['book_id']);
        if (!$book) {
            throw new \Exception("Book Not Found", 404);
        }
     
        if (Loans::where('book_id', $data['book_id'])->where('user_id', auth()->id())->whereNull('returned_at')->exists()) {
            throw new \Exception('You Already Have This Book', 400);
        }
        
   if ($book->quantity < 1) {
            throw new \Exception("Book Not Avaliable Now", 404);
        }
        return $book;
    }
    public function reves($data)
    {
        $reves = reservations::where('book_id', $data['book_id'])->where('status', 'available')->first();
        if ($reves && $reves->user_id != auth()->id()) {
            throw new \Exception('This Book Is Reserved By Another User', 403);
        }
        return $reves;
    }
    public function create($data, $reves)
    {
        return   DB::transaction(function () use ($data, $reves) {


            $loan = Loans::create([
                'user_id' => auth()->id(),
                'book_id' => $data['book_id'],
                'loans_at' => now(),
                'due_date' => $data['due_date'],
            ]);
            $loan->book->decrement('quantity');
            if ($reves) {
                $reves->update(['status' => "completed"]);
            }
            return $loan;
        });
    }


    public function loan($request)
    {
        try {

            $data = $this->valditon($request);
            $book = $this->findBook($data);
            $reves = $this->reves($data);
            $loan = $this->create($data, $reves);
            return apiResponse(201, 'Loan Created Success', new LoanResource($loan));
        } catch (\Exception $e) {
            return apiResponse($e->getCode(), $e->getMessage());
        }
    }
}
