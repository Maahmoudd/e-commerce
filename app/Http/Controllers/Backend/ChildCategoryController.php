<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ChildCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateChildCategoryRequest;
use App\Http\Services\Backend\CategoryService;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ChildCategoryController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(ChildCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.child-category.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.child-category.create', compact('categories'));
    }

    public function getSubCategories(Request $request)
    {
        $subCategories = SubCategory::where('category_id', $request->id)->where('status', 1)->get();
        return $subCategories;
    }

    public function store(CreateChildCategoryRequest $request)
    {
        $this->categoryService->createCategory($request->validated(), ChildCategory::class);
        toastr('Created Successfully!');
        return redirect()->route('admin.child-category.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $categories = Category::all();
        $childCategory = ChildCategory::findOrFail($id);
        $subCategories = SubCategory::where('category_id', $childCategory->category_id)->get();
        return view('admin.child-category.edit', compact('categories', 'childCategory', 'subCategories'));
    }

    public function update(CreateChildCategoryRequest $request, string $id)
    {
        $this->categoryService->updateCategory($request->validated(), $id, ChildCategory::class);
        toastr('Updated Successfully!');
        return redirect()->route('admin.child-category.index');
    }

    public function destroy(string $id)
    {
        $childCategory = ChildCategory::findOrFail($id);
        $childCategory->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }

    public function changeStatus(Request $request)
    {
        $this->categoryService->changeStatus($request, ChildCategory::class);
        return response(['message' => 'Status has been updated!']);
    }
}
