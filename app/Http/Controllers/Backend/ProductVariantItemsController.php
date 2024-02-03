<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantItemDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateProductVariantItemRequest;
use App\Http\Services\Backend\CategoryService;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;

class ProductVariantItemsController extends Controller
{

    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(ProductVariantItemDataTable $dataTable, $productId, $variantId)
    {
        $product = Product::findOrFail($productId);
        $variant = ProductVariant::findOrFail($variantId);
        return $dataTable->render('admin.product.product-variant-item.index',
            compact('product', 'variant'));
    }

    public function create(string $productId, string $variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);
        $product = ProductVariant::findOrFail($productId);
        return view('admin.product.product-variant-item.create',
            compact('variant', 'product'));
    }

    public function store(CreateProductVariantItemRequest $request)
    {
        ProductVariantItem::create($request->validated());
        toastr('Created Successfully!');
        return redirect()->route('admin.products-variant-item.index',
            ['productId' => $request['product_id'], 'variantId' => $request['product_variant_id']]);
    }

    public function edit(string $variantItemId)
    {
        $variantItem = ProductVariantItem::findOrFail($variantItemId);
        return view('admin.product.product-variant-item.edit', compact('variantItem'));
    }

    public function update(CreateProductVariantItemRequest $request, string $variantItemId)
    {
        $variantItem = ProductVariantItem::findOrFail($variantItemId);
        $variantItem->update($request->validated());
        toastr('Updated Successfully!');
        return redirect()->route('admin.products-variant-item.index',
            ['productId' => $variantItem->productVariant->product_id, 'variantId' => $variantItem->product_variant_id]);
    }

    public function destroy(string $variantItemId)
    {
        $variantItem = ProductVariantItem::findOrFail($variantItemId);
        $variantItem->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request)
    {
        return $this->categoryService->changeStatus($request, ProductVariantItem::class);
    }

}
