<?php

namespace App\Services\Admin;

use App\Repositories\Admin\LoanRepository;

class LoanService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private LoanRepository $loanrepo)
    {
        //
    }

    public function index(){
      return $this->loanrepo->index();
    }
    public function create($data){
        return $this->loanrepo->create($data);
    }
    public function show($id){
        return $this->loanrepo->show($id);
     

        
    }
}
