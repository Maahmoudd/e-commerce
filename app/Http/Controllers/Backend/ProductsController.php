<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateProductRequest;
use App\Http\Services\Backend\CategoryService;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{

    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.product.index');
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        return view('admin.product.create', compact('categories', 'brands'));
    }

    public function store(CreateProductRequest $request)
    {
        $validatedData = $request->validated();

        $mergedData = array_merge($validatedData, [
            'vendor_id' => Auth::user()->vendor->id,
            'is_approved' => 1
        ]);

        $this->categoryService->create($mergedData, Product::class, 'thumb_image');

        toastr('Created Successfully!');
        return redirect()->route('admin.products.index');
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
        return SubCategory::where('category_id', $request->id)->get();
    }
    public function getChildCategories(Request $request)
    {
        return ChildCategory::where('sub_category_id', $request->id)->get();
    }
}
