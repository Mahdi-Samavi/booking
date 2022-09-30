<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Category::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\CategoryCollection
     */
    public function index(Request $request)
    {
        $category = Category::query();

        $request->has('ids') ? $category->whereIn('id', explode(',', $request->ids)) : '';
        $request->has('title') ? $category->where('title', 'like', '%'.$request->title.'%') : '';
        $request->has('parent_id') ? $category->where('parent_id', $request->parent_id) : '';
        $request->has('orderBy') ? $category->orderBy(...explode(',', $request->orderBy)) : '';

        return new CategoryCollection($category->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->safe()->except('image'));

        $this->uploadImg($request, $category);

        return $this->validResponse(['message' => __('Category created successfully.')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\CategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->safe()->except('image'));

        $this->uploadImg($request, $category);

        return $this->validResponse(['message' => __('Category updated successfully.')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        $category->media()->delete();

        return $this->validResponse(['message' => __('Category removed successfully.')]);
    }

    private function uploadImg($request, $category)
    {
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $category->media()->delete();
            $category->addMediaFromRequest('image')->toMediaCollection('image');
        }
    }
}
