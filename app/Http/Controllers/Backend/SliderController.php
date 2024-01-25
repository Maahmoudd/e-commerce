<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateSliderRequest;
use App\Http\Services\Backend\SliderService;
use App\Models\Slider;

class SliderController extends Controller
{
    protected $sliderService;
    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }

    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(CreateSliderRequest $request)
    {
        $this->sliderService->createSlider($request->validated());
        toastr('Created Successfully!');
        return back();
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(CreateSliderRequest $request, string $id)
    {
        $this->sliderService->updateSlider($request, $id);
        toastr('Slider Has Been Updated!');
        return redirect()->route('admin.slider.index');
    }

    public function destroy(string $id)
    {
        //
    }
}
