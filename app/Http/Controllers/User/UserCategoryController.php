<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\User\CategoryService;
use Illuminate\Http\Request;


class UserCategoryController extends Controller
{
    public function index()
    {
        $categories =  Category::select('id', 'title', 'status', 'slug', 'description', 'created_at')
            ->active()
            ->paginate(10);
        if ($categories->isEmpty()) {
            return apiResponse(404, 'Not Found');
        }
        return apiResponse(200, 'Success', (new CategoryCollection($categories))->response()->getData());
    }


    public function show($id)
    {
        $category =  Category::select('id', 'title', 'status', 'slug', 'description', 'created_at')
            ->active()
            ->find($id);
        if (!$category) {
            return apiResponse(404, 'Category Not Found');
        }

        return apiResponse(200, 'Success', new CategoryResource($category));
    }
}
