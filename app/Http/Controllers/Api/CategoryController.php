<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryRequest;
use App\Http\Resources\CategoryCollection;
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
     * @return \App\Http\Resources\CategoryCollection
     */
    public function index(Request $request)
    {
        $category = Category::query();

        if ($request->has('ids')) {
            $category->whereIn('id', explode(',', $request->ids));
        }

        if ($request->has('name')) {
            $category->where('name', $request->name);
        }

        if ($request->has('parent_id')) {
            $category->where('parent_id', $request->parent_id);
        }

        if ($request->has('orderBy')) {
            $category->orderBy(...explode(',', $request->orderBy));
        }

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
        $image = $this->uploadImg($request);

        Category::create($request->safe()->except('image') + compact('image'));

        return response()->json(['message' => __('Category created successfully.')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category->toArray());
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
        $image = $this->uploadImg($request);

        $category->update($request->safe()->except('image') + compact('image'));

        return response()->json(['message' => __('Category updated successfully.')]);
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

        return response()->json(['message' => __('Category removed successfully.')]);
    }

    private function uploadImg($request): string
    {
        $image = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image = $file->getClientOriginalName();
            $file->store('public/img/categories');
        }

        return $image;
    }
}
