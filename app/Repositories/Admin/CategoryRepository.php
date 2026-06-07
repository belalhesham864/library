<?php

namespace App\Repositories\Admin;

use App\Models\Category;

class CategoryRepository
{

public function index(){
    return Category::select('id', 'title', 'status', 'slug', 'description', 'created_at')->active()->paginate(10);
  
}
public function create($data){
    return Category::create($data);
}
public function show($id){
    return Category::where('id', $id)->select('id', 'title', 'status', 'slug', 'description', 'created_at')->active()->first();
}
public function find($id){
    return Category::find($id);
}
public function update($category,$data){
    $category->update($data);
    return $category;
}
public function destroy($category){
    return $category->delete();
}

}
