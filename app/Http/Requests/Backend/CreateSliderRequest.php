<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CreateSliderRequest extends FormRequest
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
        $rules = [
            'type' => ['string', 'max:200'],
            'title' => ['required', 'max:200'],
            'starting_price' => ['max:200'],
            'btn_url' => ['url'],
            'serial' => ['required'],
            'status' => ['required']
        ];

        // Check if it's a creation request
        if ($this->isMethod('post')) {
            $rules['banner'] = ['required', 'image', 'max:2000'];
        } elseif ($this->isMethod('put')) {
            // If it's an update request, make 'banner' field 'nullable'
            $rules['banner'] = ['nullable', 'image', 'max:2000'];
        }

        return $rules;
    }
}
