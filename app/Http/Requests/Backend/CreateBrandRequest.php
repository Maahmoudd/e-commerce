<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CreateBrandRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:200'],
            'is_featured' => ['required'],
            'status' => ['required'],
        ];
        // Check if it's a creation request
        if ($this->isMethod('post')) {
            $rules['logo'] = ['required', 'image', 'max:2000'];
        } elseif ($this->isMethod('put')) {
            // If it's an update request, make 'logo' field 'nullable'
            $rules['logo'] = ['nullable', 'image', 'max:2000'];
        }

        return $rules;
    }
}
