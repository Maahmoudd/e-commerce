<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateProductRequest;
use App\Http\Services\Backend\CategoryService;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductsController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(VendorProductDataTable $dataTable)
    {
        return $dataTable->render('vendor.product.index');
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        return view('vendor.product.create',
            compact('categories', 'brands'));
    }

    public function store(CreateProductRequest $request)
    {
        $validatedData = $request->validated();

        $mergedData = array_merge($validatedData, [
            'vendor_id' => Auth::user()->vendor->id,
            'is_approved' => 0
        ]);

        $this->categoryService->create($mergedData, Product::class, 'thumb_image', 'uploads/products');

        toastr('Created Successfully!');
        return redirect()->route('vendor.products.index');
    }


    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }
        $subCategories = SubCategory::where('category_id', $product->category_id)->get();
        $childCategories = ChildCategory::where('sub_category_id', $product->sub_category_id)->get();
        $categories = Category::all();
        $brands = Brand::all();
        return view('vendor.product.edit',
            compact(
                'product',
                'subCategories',
                'childCategories',
                'categories',
                'brands'
            ));
    }

    public function update(CreateProductRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $mergedData = array_merge($validatedData, [
            'vendor_id' => Auth::user()->vendor->id,
        ]);

        $this->categoryService->update($mergedData,$id, Product::class,'thumb_image', 'uploads/products');
        toastr('Updated Successfully!');
        return redirect()->route('vendor.products.index');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }
        $gallery = ProductImageGallery::where('product_id', $id)->get();
        foreach ($gallery as $image){
            $this->deleteImage($image->image);
        }
        $this->deleteImage($product->thumb_image);
        $product->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request)
    {
        return $this->categoryService->changeStatus($request, Product::class);
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
