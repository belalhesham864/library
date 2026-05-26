<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\loans\LoanRequest;
use App\Http\Requests\loans\UpdateLoanRequest;
use App\Http\Resources\LoanCollection;
use App\Http\Resources\LoanResource;
use App\Models\Book;
use App\Models\Loans;
class LoansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index()
    {
        $loans=Loans::with(['user','book'])->select('id','user_id','book_id','due_date','loans_at','returned_at')->paginate(10);
     if($loans->isEmpty()){
        return apiResponse(404,'NOt Found Loans');
     }
     return apiResponse(200,'All Loans',(new LoanCollection($loans))->response()->getData());
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
      public function store(LoanRequest $request)
    {
        $data=$request->validated();
        $loan=Loans::create($data);
        if(!$loan){
             return apiResponse(400, 'Please Try again');
        }
       return apiResponse(200,'Loans Created Successfuly',new LoanResource($loan));
    }

    /**
     * Display the specified resource.
     */
      public function show($id)
    {
        $loan=Loans::with(['user','book'])->find($id);
         if (!$loan) {
            return apiResponse(404, 'Not Found');
        }
               return apiResponse(200,'Loan Successfuly',new LoanResource($loan));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
