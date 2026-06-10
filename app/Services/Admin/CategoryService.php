<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * Create a new class instance.
     */

    public function index(){
    return Category::select('id', 'title', 'status', 'slug', 'description', 'created_at')->active()->paginate(10);
    }
    public function create($data){
        $data['slug']=str::slug($data['title']);
        return Category::create($data);
    }
       public function show($id){
        return Category::where('id', $id)->select('id', 'title', 'status', 'slug', 'description', 'created_at')->active()->first();
    }
    public function update($data,$id){
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
    return $category;
    }
    public function destroy($id){
        $category=Category::find($id);
         if(!$category){
        throw new \Exception('Not Found',404);
    }
       return $category->delete();
    }
}

