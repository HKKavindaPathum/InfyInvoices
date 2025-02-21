<?php

namespace App\Http\Requests;

use App\Models\Invoice;
use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
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
        return Invoice::$rules;
    }

    public function messages(): array
    {
        return [
            'client_id.required' => __('messages.quote.client_id_required'),
            'invoice_date.required' => 'The invoice date field is required.',
            'due_date' => 'The invoice Due date field is required.',
        ];
    }
}
