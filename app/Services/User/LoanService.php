<?php

namespace App\Services\User;

use App\Repositories\User\BookRepository;
use App\Repositories\User\LoanRepository;

class LoanService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private LoanRepository $loanRepo, private BookRepository $bookRepo) {}
    public function index($userId)
    {
        return $this->loanRepo->index($userId);
    }
    public function store($data, $userId)
    {
        $book = $this->bookRepo->find($data['book_id']);
        if (!$book) {
            throw new \Exception("Book Not Found", 404);
        }
        if ($book->quantity < 1) {
            throw new \Exception("Book Not Avaliable Now", 404);
        }
        if ($this->loanRepo->userHasBook($data['book_id'], $userId)) {
            throw new \Exception('You Already Have This Book', 400);
        }
        return  $this->loanRepo->store($data, $userId);
    }
    
    public function returnLoan($id, $userId)
    {
        $loan = $this->loanRepo->findLoan($id, $userId);
        if (!$loan) {
            throw new \Exception('Not Found loan', 404);
        }
        return $this->loanRepo->returnLoan($loan);
    }
}
