<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $thumbImageRules = $this->isMethod('post') ? ['required', 'image', 'max:2000'] : ['sometimes', 'image', 'max:2000'];

        return [
            'thumb_image' => $thumbImageRules,
            'name' => ['required', 'max:200'],
            'category_id' => ['required'],
            'sub_category_id' => ['nullable'],
            'child_category_id' => ['nullable'],
            'brand_id' => ['required'],
            'sku' => ['nullable'],
            'price' => ['required'],
            'offer_price' => ['nullable'],
            'offer_start_date' => ['nullable'],
            'offer_end_date' => ['nullable'],
            'qty' => ['required'],
            'video_link' => ['nullable'],
            'short_description' => ['required', 'max: 600'],
            'long_description' => ['required'],
            'product_type' => ['nullable'],
            'seo_title' => ['nullable','max:200'],
            'seo_description' => ['nullable','max:250'],
            'status' => ['required'],
        ];
    }
}
