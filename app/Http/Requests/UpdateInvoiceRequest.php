<?php

namespace App\Http\Requests;

use App\Models\Invoice;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = Invoice::$rules;
        $rules['invoice_id'] = 'required|unique:invoices,invoice_id,'.$this->route('invoice')->id;

        return $rules;
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
