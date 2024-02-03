<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductVariantItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
        return [
            'product_variant_id' => $this->isMethod('post') ? ['integer', 'required'] : ['integer'],
            'product_id' => $this->isMethod('post') ? ['integer', 'required'] : ['integer'],
            'name' => ['required', 'max:200'],
            'price' => ['integer', 'required'],
            'is_default' => ['required'],
            'status' => ['required'],
        ];
    }
}
