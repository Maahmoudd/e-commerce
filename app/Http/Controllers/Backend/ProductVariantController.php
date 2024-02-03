<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateProductVariantRequest;
use App\Http\Services\Backend\CategoryService;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{

    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request, ProductVariantDataTable $dataTable)
    {
        $product = Product::findOrFail($request->product);
        return $dataTable->render('admin.product.product-variant.index', compact('product'));
    }

    public function create()
    {
        return view('admin.product.product-variant.create');
    }

    public function store(CreateProductVariantRequest $request)
    {
        ProductVariant::create($request->validated());
        toastr('Created Successfully!');
        return redirect()->route('admin.products-variant.index', ['product' => $request->product_id]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $variant = ProductVariant::findOrFail($id);
        return view('admin.product.product-variant.edit', compact('variant'));
    }

    public function update(CreateProductVariantRequest $request, string $id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->update($request->validated());
        toastr('Updated Successfully!');
        return redirect()
            ->route('admin.products-variant.index',
            ['product' => $variant->product_id]);
    }

    public function destroy(string $id)
    {
        ProductVariant::findOrFail($id)->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request)
    {
        return $this->categoryService->changeStatus($request, ProductVariant::class);
    }
}
