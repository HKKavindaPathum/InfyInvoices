<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $rules = User::$rules;
        $rules['email'] = 'unique:users,email,'.$this->route('user')->id;
        $rules['password'] = 'nullable|same:password_confirmation|min:6';

        return $rules;
    }
}
