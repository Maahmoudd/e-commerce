<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateBrandRequest;
use App\Http\Services\Backend\CategoryService;
use App\Models\Brand;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class BrandsController extends Controller
{

    use ImageUploadTrait;
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(BrandDataTable $dataTable)
    {
        return $dataTable->render('admin.brand.index');
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(CreateBrandRequest $request)
    {
        $this->categoryService->create($request->validated(), Brand::class);
        toastr('Created Successfully!');
        return redirect()->route('admin.brand.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(CreateBrandRequest $request, string $id)
    {
        $this->categoryService->update($request->validated(), $id, Brand::class, 'logo');
        toastr('Updated Successfully!');
        return redirect()->route('admin.brand.index');
    }

    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $this->deleteImage($brand->logo);
        $brand->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request)
    {
        $this->categoryService->changeStatus($request, Brand::class);
        return response(['message' => 'Status Updated!']);
    }
}
