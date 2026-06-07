<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\loans\LoanRequest;
use App\Http\Resources\LoanCollection;
use App\Http\Resources\LoanResource;
use App\Models\Book;
use App\Models\Loans;
use App\Services\User\LoanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserLoanController extends Controller
{
    public function __construct(private LoanService $loanService) {}
    public function index()
    {
        $userId = request()->user()->id;

        $loans = $this->loanService->index($userId);

        if ($loans->isEmpty()) {
            return apiResponse(404, 'No Loans Found');
        }
        return apiResponse(200, 'My Loans', (new LoanCollection($loans))->response()->getData());
    }


    public function store(LoanRequest $request)
    {
        $data = $request->validated();
        $userId = request()->user()->id;
        try {
            $loan = $this->loanService->store($data, $userId);
            return apiResponse(201, 'Book Loaned Successfully', new LoanResource($loan));
        } catch (\Exception $e) {

            return apiResponse($e->getCode(), $e->getMessage());
        }
    }
    public function return($id)
    {
                $userId = request()->user()->id;
                try{
                    $loan=$this->loanService->returnLoan($id,$userId);                    
                    return apiResponse(200, 'Book Returned Successfully', new LoanResource($loan->fresh()->load('book')));
                    }catch(\Exception $e){
                        return apiResponse($e->getCode(),$e->getMessage());
                    }
    }
}
