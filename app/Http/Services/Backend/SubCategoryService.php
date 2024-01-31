<?php

namespace App\Http\Services\Backend;

use App\Models\SubCategory;
use Illuminate\Support\Str;

class SubCategoryService
{
    public function createSubCategory($request)
    {
        $request['slug'] = Str::slug($request['name']);
        SubCategory::create($request);
    }

    public function updateSubCategory($request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $request['slug'] = Str::slug($request['name']);
        $subCategory->update($request);
    }


}
