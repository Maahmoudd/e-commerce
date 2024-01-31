<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateCategoryRequest;
use App\Http\Requests\Backend\CreateSubCategoryRequest;
use App\Http\Services\Backend\SubCategoryService;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    protected $subCategoryService;

    public function __construct(SubCategoryService $subCategoryService)
    {
        $this->subCategoryService = $subCategoryService;
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
        $this->subCategoryService->createSubCategory($request->validated());
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
        $this->subCategoryService->updateSubCategory($request->validated(), $id);
        toastr('Updated Successfully!');
        return redirect()->route('admin.sub-category.index');
    }

    public function destroy(string $id)
    {
        //
    }
}
