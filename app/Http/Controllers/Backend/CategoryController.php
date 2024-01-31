<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateCategoryRequest;
use App\Http\Services\Backend\CategoryService;
use App\Models\Category;
use App\Models\SubCategory;
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
        $this->categoryService->createCategory($request->validated(), Category::class);
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
        $this->categoryService->updateCategory($request->validated(), $id, Category::class);
        toastr('Category Updated!');
        return redirect()->route('admin.category.index');
    }

    public function destroy(string $id)
    {
        $response = $this->categoryService->deleteCategory($id,
            Category::class,
            SubCategory::class,
            'category_id');
        return response($response);
    }

    public function changeStatus(Request $request, )
    {
        $this->categoryService->changeStatus($request, Category::class);
        return response(['message' => 'Status has been updated!']);
    }
}
