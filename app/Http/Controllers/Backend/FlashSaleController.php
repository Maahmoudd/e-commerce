<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FlashSaleItemDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateFlashSaleItemRequest;
use App\Http\Requests\Backend\UpdateFlashSaleRequest;
use App\Http\Services\Backend\CategoryService;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index(FlashSaleItemDataTable $dataTable)
    {
        $flashSaleDate = FlashSale::first();
        $products = Product::approvedAndActive()->latest()->get();
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

    public function changeShowAtHomeStatus(Request $request)
    {
        $flashSaleItem = FlashSaleItem::findOrFail($request->id);
        $flashSaleItem->show_at_home = $request->status == 'true' ? 1 : 0;
        $flashSaleItem->save();

        return response(['message' => 'Status has been updated!']);
    }

    public function changeStatus(Request $request)
    {
        $flashSaleItem = FlashSaleItem::findOrFail($request->id);
        $flashSaleItem->status = $request->status == 'true' ? 1 : 0;
        $flashSaleItem->save();

        return response(['message' => 'Status has been updated!']);
    }

    public function destroy(string $id)
    {
        $flashSaleItem = FlashSaleItem::findOrFail($id);
        $flashSaleItem->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
