<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateSubCategoryRequest;
use App\Http\Services\Backend\CategoryService;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(SubCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.sub-category.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.sub-category.create', compact('categories'));
    }

    public function store(CreateSubCategoryRequest $request)
    {
        $this->categoryService->create($request->validated(), SubCategory::class, null);
        toastr('Created Successfully!');
        return redirect()->route('admin.sub-category.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $categories = Category::all();
        $subCategory = SubCategory::findOrFail($id);
        return view('admin.sub-category.edit', compact('subCategory', 'categories'));
    }

    public function update(CreateSubCategoryRequest $request, string $id)
    {
        $this->categoryService->update($request->validated(), $id, SubCategory::class, null);
        toastr('Updated Successfully!');
        return redirect()->route('admin.sub-category.index');
    }

    public function destroy(string $id)
    {
        $response = $this->categoryService->destroy($id,
            SubCategory::class,
            ChildCategory::class,
            'sub_category_id');
        return response($response);
    }

    public function changeStatus(Request $request)
    {
        $this->categoryService->changeStatus($request, SubCategory::class);
        return response(['message' => 'Status has been updated!']);
    }
}
