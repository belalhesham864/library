<?php

namespace App\Services\User;

use App\Models\Category;
use App\Repositories\User\CategoryRepository;

class CategoryService
{
    /**
     * Create a new class instance.
     */

    public function index()
    {
        return   Category::select('id', 'title', 'status', 'slug', 'description', 'created_at')
            ->active()
            ->paginate(10);
    }
    public function show($id)
    {
        return Category::select('id', 'title', 'status', 'slug', 'description', 'created_at')
            ->active()
            ->find($id);
    }
}
