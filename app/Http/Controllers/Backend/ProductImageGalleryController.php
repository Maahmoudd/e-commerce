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

    public function create()
    {
        //
    }

    public function store(CreateProductGalleryRequest $request)
    {
        $imagePaths = $this->uploadMultiImage($request->validated(), 'image', 'uploads');
        foreach ($imagePaths as $path){
            ProductImageGallery::create(['image' => $path, 'product_id' => $request->product]);
        }
        toastr('Uploaded Successfully!');
        return back();
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
}
