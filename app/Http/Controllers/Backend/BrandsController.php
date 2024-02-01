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
        $this->categoryService->create($request->validated(), Brand::class, 'logo');
        toastr('Created Successfully!');
        return redirect()->route('admin.brand.index');
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
