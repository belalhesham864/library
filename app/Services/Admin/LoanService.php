<?php

namespace App\Services\Admin;

use App\Models\Loans;
use App\Repositories\Admin\LoanRepository;

class LoanService
{
    /**
     * Create a new class instance.
     */

    public function index(){
    return Loans::with(['user','book'])->select('id','user_id','book_id','due_date','loans_at','returned_at')->paginate(10);
    }
    public function create($data){
    return Loans::create($data);
    }
    public function show($id){
return Loans::with(['user','book'])->find($id);
     

        
    }
}
