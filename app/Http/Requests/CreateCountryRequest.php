<?php

namespace App\Http\Requests;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;

class CreateCountryRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return Country::$rules;
    }

    public function messages(): array
    {
        return [
            'short_code.alpha' => __('messages.placeholder.short_code_only_alpha'),
        ];
    }
}
