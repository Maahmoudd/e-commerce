<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductImageGalleryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateProductGalleryRequest;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductImageGalleryController extends Controller
{
    use ImageUploadTrait;

    public function index(Request $request, VendorProductImageGalleryDataTable $dataTable)
    {
        $product = Product::findOrFail($request->product);
        if($product->vendor_id !== Auth::user()->vendor->id){
            abort(404);
        }
        return $dataTable->render('vendor.product.image-gallery.index', compact('product'));
    }


    public function store(CreateProductGalleryRequest $request)
    {
        $imagePaths = $this->uploadMultiImage($request->validated(), 'image', 'uploads/gallery');
        foreach ($imagePaths as $path){
            ProductImageGallery::create(['image' => $path, 'product_id' => $request->product]);
        }
        toastr('Uploaded Successfully!');
        return back();
    }

    public function destroy(string $id)
    {
        $gallery = ProductImageGallery::findOrFail($id);
        if($gallery->product->vendor_id !== Auth::user()->vendor->id){
            abort(404);
        }
        $this->deleteImage($gallery->image);
        $gallery->delete();

        return response(['status' => 'success','message' => 'Deleted Successfully!']);
    }
}
