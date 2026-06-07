<?php

namespace App\Services\Admin;

use App\Repositories\Admin\CategoryRepository;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private CategoryRepository $categoryRepo){}

    public function index(){
        return $this->categoryRepo->index();
    }
    public function create($data){
        $data['slug']=str::slug($data['title']);
        return $this->categoryRepo->create($data);
    }
       public function show($id){
        return $this->categoryRepo->show($id);
    }
    public function update($data,$id){
        if(empty($data)){
           throw new \Exception('not found data',400); 
        }
        $category=$this->categoryRepo->find($id);
        if(!$category){
           throw new \Exception('not found category',404); 
        }
        if($data['title']){
            $data['slug']= $data['title'];
        }

        return $this->categoryRepo->update($category,$data);
    }
    public function destroy($id){
        $category=$this->categoryRepo->find($id);
         if(!$category){
        throw new \Exception('Not Found',404);
    }
        return $this->categoryRepo->destroy($category);
    }
}

