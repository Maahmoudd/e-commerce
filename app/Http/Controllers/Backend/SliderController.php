<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateSliderRequest;
use App\Http\Services\Backend\SliderService;
use App\Models\Slider;
use Illuminate\Http\Request;
use function Symfony\Component\String\s;

class SliderController extends Controller
{
    protected $sliderService;
    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }

    public function index()
    {
        return view('admin.slider.index');
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
