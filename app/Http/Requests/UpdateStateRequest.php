<?php

namespace App\Http\Requests;

use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStateRequest extends FormRequest
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
        $rules = State::$rules;
        $rules['name'] = $rules['name'].$this->route('state')->id;

        return $rules;
    }
}
