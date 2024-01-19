<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDeletionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        return [
            'password' => ['required', 'current_password'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->validateWithBag('userDeletion', $this->rules());
    }
}
