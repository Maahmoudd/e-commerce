<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FlashSaleItemDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateFlashSaleItemRequest;
use App\Http\Requests\Backend\UpdateFlashSaleRequest;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index(FlashSaleItemDataTable $dataTable)
    {
        $flashSaleDate = FlashSale::first();
        $products = Product::query()->where('is_approved', 1)
            ->where('status', 1)
            ->latest()->get();
        return $dataTable->render('admin.flash-sale.index',
            compact('flashSaleDate', 'products'));
    }

    public function update(UpdateFlashSaleRequest $request)
    {
        FlashSale::updateOrCreate(['id' => 1], $request->validated());
        toastr('Updated Successfully!');
        return back();
    }

    public function create(CreateFlashSaleItemRequest $request)
    {
        FlashSaleItem::create($request->validated());
        toastr('Product Added Successfully!');
        return back();
    }
}
