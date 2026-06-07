<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Services\User\CategoryService;
use Illuminate\Http\Request;


class UserCategoryController extends Controller
{
    public function __construct(private CategoryService $category_service) {}
    public function index()
    {
        $categories = $this->category_service->index();
        if ($categories->isEmpty()) {
            return apiResponse(404, 'Not Found');
        }
        return apiResponse(200, 'Success', (new CategoryCollection($categories))->response()->getData());
    }


    public function show($id)
    {
        $category = $this->category_service->show($id);
        if (!$category) {
            return apiResponse(404, 'Category Not Found');
        }

        return apiResponse(200, 'Success', new CategoryResource($category));
    }
}
