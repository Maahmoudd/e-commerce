<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CreateChildCategoryRequest extends FormRequest
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
            'category_id' => ['required'],
            'sub_category_id' => ['required'],
            'name' => ['required', 'max:200'],
            'status' => ['required'],
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $childCategoryId = $this->route('child_category');
            $rules['name'][] = 'unique:child_categories,name,' . $childCategoryId;
        } else {
            $rules['name'][] = 'unique:child_categories,name';
        }

        return $rules;
    }
}
