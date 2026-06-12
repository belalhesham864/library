<?php

namespace App\services\User;

use App\Http\Resources\LoanResource;
use App\Models\Loans;
use App\Models\reservations;
use App\Notifications\BookAvilableNotifaction;
use Exception;
use Illuminate\Support\Facades\DB;

class returnLoanServies
{
    /**
     * Create a new class instance.
     */
    public function getloan($id)
    {
        return DB::transaction(function ()use ($id) {

            $loan =   Loans::where('id', $id)->where('user_id', auth()->id())->whereNull('returned_at')->first();
            if (!$loan) {
               return apiResponse(404,'Not Found loan');
            }
            $loan->update(['returned_at' => now()]);
            $loan->book->increment('quantity');
            return $loan;
        });
    }
    public function reves($loan)
    {
        $reves = reservations::where('book_id', $loan->book_id)
            ->where('status', 'pending')
            ->orderBy('created_at')
            ->first();
        if ($reves) {
            $reves->update([
                'status' => 'available',
                'expires_at' => now()->addDay()
            ]);
            $reves->user->notify(new BookAvilableNotifaction($loan->book));
        }
    }
    public function return($id){
        $loan=$this->getloan($id);
        $this->reves($loan);
                    return apiResponse(200, 'Book Returned Successfully', new LoanResource($loan->fresh()->load('book')));

    }
}
