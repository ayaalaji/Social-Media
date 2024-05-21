<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Trait\ApiResponseTrait;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return $this->apiResponse(CategoryResource::collection($categories),'all category',200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $request->validated();
        $category=new Category();
        $category->name=$request->name;
        $category->save();
        return $this->apiResponse ($category,'you added category successfully',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return  $this->apiResponse(new CategoryResource($category),'this is your request',200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $request->validated();
        $category->name=$request->name;
        $category->save();
        return $this->apiResponse(new CategoryResource($category),'you update category',200);
    }
 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->apiDelete('you deleted successfully',200);
    }
}
