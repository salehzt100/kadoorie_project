<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::all());
    }
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        $validated = $request->validated();

        $category = Category::query()->create($validated);

        return new CategoryResource($category);
    }
    public function show(Category $category) :CategoryResource
    {

        return new CategoryResource($category);
    }
    public function update(UpdateCategoryRequest $request, Category $category) :CategoryResource
    {
        $category->update($request->validated());
        return new CategoryResource($category);
    }
    public function destroy(Category $category) :Response
    {
        $category->delete();
        return response()->noContent();
    }
}
