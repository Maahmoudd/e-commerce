<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ShippingRuleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateShippingRuleRequest;
use App\Models\ShippingRule;
use Illuminate\Http\Request;

class ShippingRulesController extends Controller
{

    public function index(ShippingRuleDataTable $dataTable)
    {
        return $dataTable->render('admin.shipping-rule.index');
    }

    public function create()
    {
        return view('admin.shipping-rule.create');
    }

    public function store(CreateShippingRuleRequest $request)
    {
        ShippingRule::create($request->validated());
        toastr('Created Successfully!');
        return redirect()->route('admin.shipping-rule.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $shipping = ShippingRule::findOrFail($id);
        return view('admin.shipping-rule.edit', compact('shipping'));
    }

    public function update(CreateShippingRuleRequest $request, string $id)
    {
        $shippingRule = ShippingRule::findOrFail($id);
        $shippingRule->update($request->validated());
        toastr('Updated!');
        return redirect()->route('admin.shipping-rule.index');
    }

    public function destroy(string $id)
    {
        ShippingRule::destroy($id);
        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }

    public function changeStatus(Request $request)
    {
        $shipping = ShippingRule::findOrFail($request->id);
        $shipping->status = $request->status == 'true' ? 1 : 0;
        $shipping->save();

        return response(['message' => 'Status has been updated!']);
    }
}
