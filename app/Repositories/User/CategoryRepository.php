<?php

namespace App\Repositories\User;

use App\Models\Category;

class CategoryRepository
{
    public function index()
    {
        return  Category::select('id', 'title', 'status', 'slug', 'description', 'created_at')
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
