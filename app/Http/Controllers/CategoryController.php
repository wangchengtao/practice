<?php

namespace App\Http\Controllers;

use App\Data\PaginationResultData;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::paginate(10);

        return $this->paginate(CategoryResource::collection($categories));
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return $this->success();
    }

    public function show(Category $category)
    {
        return $this->success(new CategoryResource($category));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return $this->success();
    }

    public function destroy(Category $category)
    {
        $category->topics()->update(['category_id' => 0]);
        $category->delete();

        return $this->success();
    }
}
