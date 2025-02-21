<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
        $rules = Client::$rules;
        $rules['email'] = 'required|email:filter|unique:users,email,'.$this->route('client')->user->id;
        $rules['password'] = 'nullable|same:password_confirmation|min:6';
        $rules['contact'] = 'nullable|unique:users,contact,'.$this->route('client')->user->id;

        return $rules;
    }
}
