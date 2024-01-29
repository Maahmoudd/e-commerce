<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateCategoryRequest;
use App\Http\Services\Backend\CategoryService;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.category.index');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(CreateCategoryRequest $request)
    {
        $this->categoryService->createCategory($request->validated());
        toastr('Created Successfully!');
        return redirect()->route('admin.category.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(CreateCategoryRequest $request, string $id)
    {
        $this->categoryService->updateCategory($request->validated(), $id);
        toastr('Category Updated!');
        return redirect()->route('admin.category.index');
    }

    public function destroy(string $id)
    {
        $this->categoryService->deleteCategory($id);
        toastr('Category Deleted!');
        return back();
    }

    public function changeStatus(Request $request)
    {
        $this->categoryService->changeStatus($request);
        return response(['message' => 'Status has been updated!']);
    }
}
