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
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function getSubCategories(Request $request)
    {
        $subCategories = SubCategory::where('category_id', $request->id)->where('status', 1)->get();
        return $subCategories;
    }
}
