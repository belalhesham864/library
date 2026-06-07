<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\category\CategoryRequest;
use App\Http\Requests\category\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
           public function __construct(private CategoryService $categorySer){}

    public function index()
    {
        $categories =$this->categorySer->index();
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
    $category=$this->categorySer->create($data);
       
        if (!$category) {
            return apiResponse(400, 'Please Try again');
        }
        return apiResponse(201, 'Category Created Successfuly', new CategoryResource($category->fresh()));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = $this->categorySer->show($id);
        if (!$category) {
            return apiResponse(404, 'Category Not Found');
        }
        return apiResponse(200, "Category details", new CategoryResource($category));
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
  

        public function update(UpdateCategoryRequest $request, $id)
    {
    try{
          $data = $request->validated();
      $category= $this->categorySer->update($data,$id);
        return apiResponse(200, 'Updated Successfully', new CategoryResource($category));
        }catch(\Exception $e){
            return apiResponse($e->getCode(),$e->getMessage());
        }
    }

       public function destroy($id)
    {
        try{
     $this->categorySer->destroy($id);

             return apiResponse(200, 'Deleted Successfully');
            }catch(\Exception $e){
                return apiResponse($e->getCode(),$e->getMessage());
            }
    }
}
