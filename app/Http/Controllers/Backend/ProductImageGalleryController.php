<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductImageGalleryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateProductGalleryRequest;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class ProductImageGalleryController extends Controller
{

    use ImageUploadTrait;
    public function index(Request $request, ProductImageGalleryDataTable $dataTable)
    {
        $product = Product::findOrFail($request->product);
        return $dataTable->render('admin.product.image-gallery.index', compact('product'));
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
        $this->deleteImage($gallery->image);
        $gallery->delete();

        return response(['status' => 'success','message' => 'Deleted Successfully!']);
    }
}
