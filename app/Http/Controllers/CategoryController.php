<?php

namespace App\Http\Controllers;

use App\Http\Requests\category\CategoryRequest;
use App\Http\Requests\category\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::select('id', 'title', 'status', 'slug', 'description', 'created_at')->active()->paginate(10);
        if ($categories->isEmpty()) {
            return apiResponse(404, 'Not Found');
        }
        return apiResponse(200, 'Success', (new CategoryCollection($categories))->response()->getData());
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
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        $category = Category::create($data);

        if (!$category) {
            return apiResponse(400, 'Please Try again');
        }
        return apiResponse(201, 'Data Created Successfuly', new CategoryResource($category->fresh()));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::where('id', $id)->select('id', 'title', 'status', 'slug', 'description', 'created_at')->active()->first();
        if (!$category) {
            return apiResponse(404, 'Category Not Found');
        }
        return apiResponse(200, "Category details", new CategoryResource($category));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $data = $request->validated();
        if (empty($data)) {
            return apiResponse(422, 'No data provided');
        }
        $category = Category::find($id);
        if (!$category) {
            return apiResponse(404, 'Category Not Found');
        }
        if ($request->has('title')) {
            $data['slug'] = Str::slug($request->title);
        }
        $category->update($data);
        return apiResponse(200, 'Updated Successfully', new CategoryResource($category->fresh()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return apiResponse(404, 'Category Not Found');
        }

        $category->delete();
        return apiResponse(200, 'Deleted Successfully');
    }
}
