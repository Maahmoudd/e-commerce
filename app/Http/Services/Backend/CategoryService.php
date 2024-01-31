<?php

namespace App\Http\Services\Backend;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function createCategory($request)
    {
        $request['slug'] = Str::slug($request['name']);
        Category::create($request);
    }

    public function updateCategory($request, $id)
    {
        $category = Category::findOrFail($id);
        $request['slug'] = Str::slug($request['name']);
        $category->update($request);
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }

    public function changeStatus($request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();
    }

}