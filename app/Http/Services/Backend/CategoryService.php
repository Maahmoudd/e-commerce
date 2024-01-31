<?php

namespace App\Http\Services\Backend;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function createCategory($request, $object)
    {
        $request['slug'] = Str::slug($request['name']);
        $object::create($request);
    }

    public function updateCategory($request, $id, $object)
    {
        $category = $object::findOrFail($id);
        $request['slug'] = Str::slug($request['name']);
        $category->update($request);
    }

    public function deleteCategory($id, $object)
    {
        $category = $object::findOrFail($id);
        $category->delete();
    }

    public function changeStatus($request, $object)
    {
        $category = $object::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();
    }

}
