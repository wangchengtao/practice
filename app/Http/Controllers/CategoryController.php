<?php

namespace App\Http\Controllers;

use App\Data\PaginationResultData;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Knuckles\Scribe\Attributes\ResponseFromFile;

#[Group('Category', '分类')]
class CategoryController extends Controller
{
    #[Endpoint('列表')]
    #[ResponseFromFile('responses/category/index.json')]
    #[ResponseFromApiResource(CategoryResource::class, Category::class, paginate: 10)]
    public function index(Request $request)
    {
        $categories = Category::paginate(10);

        return $this->paginate(CategoryResource::collection($categories));
    }

    #[Endpoint('创建')]
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return $this->success();
    }

    #[Endpoint('详情')]
    #[ResponseFromFile('responses/category/category.json')]
    #[ResponseFromApiResource(CategoryResource::class, Category::class)]
    public function show(Category $category)
    {
        return $this->success(new CategoryResource($category));
    }

    #[Endpoint('更新')]
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return $this->success();
    }

    #[Endpoint('删除')]
    public function destroy(Category $category)
    {
        $category->topics()->update(['category_id' => 0]);
        $category->delete();

        return $this->success();
    }
}
