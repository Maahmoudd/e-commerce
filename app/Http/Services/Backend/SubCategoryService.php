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


}
