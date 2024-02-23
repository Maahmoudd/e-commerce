<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RazorpaySettingRequest extends FormRequest
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
            'status',
            'country_name',
            'currency_name',
            'currency_rate',
            'razorpay_key',
            'razorpay_secret_key'
        ];
    }
}
