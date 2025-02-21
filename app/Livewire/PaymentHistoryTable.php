<?php

namespace App\Livewire;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PaymentHistoryTable extends LivewireTableComponent
{
    protected $model = Payment::class;

    public $invoiceId = null;

    public function mount(int $invoiceId): void
    {
        $this->invoiceId = $invoiceId;
    }

    public function placeholder()
    {
        return view('livewire.common_listing_skeleton');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setQueryStringStatus(false);

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('amount')) {
                return [
                    'class' => 'd-flex justify-content-end',
                ];
            }
            if ($column->isField('payment_mode')) {
                return [
                    'class' => 'text-center',
                ];
            }

            return [];
        });

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if (in_array($column->getField(), ['amount'])) {
                return [
                    'style' => 'width: 100px',
                ];
            }
            if (in_array($column->getField(), ['payment_mode'])) {
                return [
                    'class' => 'text-center',
                ];
            }

            return [
            ];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.payment.payment_date'), 'payment_date')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    return view('transactions.components.invoice-id-payment-date')
                        ->withValue([
                            'payment-date' => $row->payment_date,
                        ]);
                }),
            Column::make(__('messages.invoice.paid_amount'), 'amount')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    return getInvoiceCurrencyAmount($row->amount, $row->invoice->currency_id, true);
                }),
            Column::make(__('messages.payment.payment_method'), 'payment_mode')
                ->searchable()
                ->view('transactions.components.payment-mode'),
            Column::make(__('messages.common.status'), 'payment_mode')
                ->searchable()
                ->view('transactions.components.transaction-status'),
        ];
    }

    public function builder(): Builder
    {
        $query = Payment::where('invoice_id', $this->invoiceId)->with('invoice')->select('payments.*');

        return $query;
    }
}
