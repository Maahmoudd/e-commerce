<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'icon' => ['required', 'not_in:empty'],
            'name' => ['required', 'max:200'],
            'status' => ['required'],
        ];

        // Check if updating (editing) an existing category
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $categoryId = $this->route('category'); // Assuming 'category' is the route parameter name
            $rules['name'][] = 'unique:categories,name,' . $categoryId;
        } else {
            // If creating a new category, apply 'unique' rule without the current ID
            $rules['name'][] = 'unique:categories,name';
        }

        return $rules;
    }
}
