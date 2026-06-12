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
        $categories =Category::select('id', 'title', 'status', 'slug', 'description', 'created_at')->active()->paginate(10);
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
         $data['slug']=str::slug($data['title']);
        $category=Category::create($data);
       
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
        $category = Category::where('id', $id)->select('id', 'title', 'status', 'slug', 'description', 'created_at')->active()->first();
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
   if(empty($data)){
           throw new \Exception('not found data',400); 
        }
        $category=Category::find($id);
        if(!$category){
           throw new \Exception('not found category',404); 
        }
        if($data['title']){
            $data['slug']= $data['title'];
        }

        $category->update($data);
                return apiResponse(200, 'Updated Successfully', new CategoryResource($category));
        }catch(\Exception $e){
            return apiResponse($e->getCode(),$e->getMessage());
        }
    }

       public function destroy($id)
    {
        try{
 $category=Category::find($id);
         if(!$category){
        throw new \Exception('Not Found',404);
    }
        $category->delete();
       return apiResponse(200, 'Deleted Successfully');
    }
            catch(\Exception $e){
                return apiResponse($e->getCode(),$e->getMessage());
            }
    }
}
