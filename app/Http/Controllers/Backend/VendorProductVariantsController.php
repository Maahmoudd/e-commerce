<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateProductVariantRequest;
use App\Http\Services\Backend\CategoryService;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductVariantsController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index(Request $request, VendorProductVariantDataTable $dataTable)
    {
        $product = Product::findOrFail($request->product);

        /** Check product vendor */
        if($product->vendor_id !== Auth::user()->vendor->id){
            abort(404);
        }

        return $dataTable->render('vendor.product.product-variant.index', compact('product'));
    }

    public function create()
    {
        return view('vendor.product.product-variant.create');
    }

    public function store(CreateProductVariantRequest $request)
    {
        ProductVariant::create($request->validated());
        toastr('Created Successfully!');
        return redirect()->route('vendor.products-variant.index', ['product' => $request->product_id]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $variant = ProductVariant::findOrFail($id);
        /** Check product vendor */
        if($variant->product->vendor_id !== Auth::user()->vendor->id){
            abort(404);
        }
        return view('vendor.product.product-variant.edit', compact('variant'));
    }

    public function update(CreateProductVariantRequest $request, string $id)
    {
        $variant = ProductVariant::findOrFail($id);
        if($variant->product->vendor_id !== Auth::user()->vendor->id){
            abort(404);
        }
        $variant->update($request->validated());
        toastr('Updated Successfully!');
        return redirect()
            ->route('vendor.products-variant.index',
                ['product' => $variant->product_id]);
    }

    public function destroy(string $id)
    {
        $variant = ProductVariant::findOrFail($id);
        if($variant->product->vendor_id !== Auth::user()->vendor->id){
            abort(404);
        }

        $variant->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request)
    {
        return $this->categoryService->changeStatus($request, ProductVariant::class);
    }
}
