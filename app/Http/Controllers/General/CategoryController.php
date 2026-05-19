<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * List all visible categories.
     */
    public function index()
    {
        return response()->json(
            Category::where('is_visible', true)->orderBy('name')->get()
        );
    }

    /**
     * Show a single category with its kitchens.
     */
    public function show(Category $category)
    {
        return response()->json(
            $category->load('kitchens')
        );
    }

    /**
     * Create a category (admin only — enforced via route middleware).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100|unique:categories,name',
            'icon'       => 'nullable|string|max:100',
            'popularity' => 'nullable|in:low,medium,high',
            'is_visible' => 'boolean',
        ]);

        $category = Category::create($data);
        return response()->json($category, 201);
    }

    /**
     * Update a category (admin only).
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'       => 'sometimes|required|string|max:100|unique:categories,name,' . $category->id,
            'icon'       => 'nullable|string|max:100',
            'popularity' => 'nullable|in:low,medium,high',
            'is_visible' => 'boolean',
        ]);

        $category->update($data);
        return response()->json($category->fresh());
    }

    /**
     * Delete a category (admin only).
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
