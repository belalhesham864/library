<?php

namespace App\Services\User;

use App\Repositories\User\CategoryRepository;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private CategoryRepository $categoryrepo) {}

    public function index()
    {
        return $this->categoryrepo->index();
    }
    public function show($id)
    {
        return $this->categoryrepo->show($id);
    }
}
