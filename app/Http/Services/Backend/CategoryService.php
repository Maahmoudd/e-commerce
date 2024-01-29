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

}
