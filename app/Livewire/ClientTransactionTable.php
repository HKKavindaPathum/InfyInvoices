<?php

namespace App\Livewire;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ClientTransactionTable extends LivewireTableComponent
{
    protected $model = Payment::class;

    protected string $tableName = 'payments';

    public bool $showFilterOnHeader = true;

    public $filterComponent = ['transactions.components.filter_and_export', Payment::PAYMENT_MODE, Payment::PAYMENT_STATUS];

    protected $listeners = ['changePaymentModeFilter', 'changePaymentStatusFilter', 'resetPageTable'];

    public $paymentModeFilter = Payment::ALL;

    public $paymentStatusFilter = Payment::STATUS_ALL;

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
            if ($column->isField('id')) {
                return [
                    'class' => 'text-center',
                ];
            }

            return [
            ];
        });

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if (in_array($column->getField(), ['payment_mode'])) {
                return [
                    'class' => 'text-center',
                ];
            }
            if (in_array($column->getField(), ['invoice_id'])) {
                return [
                    'class' => 'w-25',
                ];
            }
            if (in_array($column->getField(), ['payment_date'])) {
                return [
                    'class' => 'w-35',
                ];
            }
            if (in_array($column->getField(), ['amount'])) {
                return [
                    'class' => 'text-end w-35',
                ];
            }
            if ($column->getField() === 'id') {
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
            Column::make(__('messages.invoice.invoice_id'), 'invoice.invoice_id')
//                ->sortable()
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    return view('transactions.components.invoice-id-payment-date')
                        ->withValue([
                            'invoice-id-route' => route('client.invoices.show', $row->invoice->id),
                            'invoice-id' => $row->invoice->invoice_id,
                        ]);
                }),
            Column::make('Last Name', 'invoice.client.user.last_name')
                ->sortable()
                ->searchable()
                ->hideif('admin'),
            Column::make(__('messages.payment.payment_date'), 'payment_date')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    return view('transactions.components.invoice-id-payment-date')
                        ->withValue([
                            'payment-date' => $row->payment_date,
                        ]);
                }),
            Column::make(__('messages.invoice.amount'), 'amount')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    return getInvoiceCurrencyAmount($row->amount, $row->invoice->currency_id, true);
                }),
            Column::make(__('messages.invoice.payment_method'), 'payment_mode')
                ->searchable()
                ->view('transactions.components.payment-mode'),
            Column::make(__('messages.common.status'), 'payment_mode')
                ->searchable()
                ->view('transactions.components.transaction-status'),
            Column::make(__('messages.common.attachment'), 'id')
                ->searchable()
                ->view('transactions.components.transaction-attachment'),
        ];
    }

    public function builder(): Builder
    {
        $query = Payment::with('invoice.client.user')->whereHas('invoice.client')
            ->where('user_id', Auth::id())->select('payments.*');

        $query->when(isset($this->paymentModeFilter), function (Builder $q) {
            if ($this->paymentModeFilter != Payment::ALL) {
                $q->where('payment_mode', $this->paymentModeFilter);
            }
        });

        $query->when(isset($this->paymentStatusFilter), function (Builder $q) {
            if ($this->paymentStatusFilter != Payment::STATUS_ALL) {
                $q->where('is_approved', $this->paymentStatusFilter);
            }
        });

        return $query;
    }

    public function changePaymentModeFilter($paymentMode)
    {
        $this->resetPage($this->getComputedPageName());
        $this->paymentModeFilter = $paymentMode;
        $this->setBuilder($this->builder());
    }

    public function changePaymentStatusFilter($status)
    {
        $this->resetPage($this->getComputedPageName());
        $this->paymentStatusFilter = $status;
        $this->setBuilder($this->builder());
    }

    public function placeholder()
    {
        return view('livewire.transaction_listing_skeleton');
    }
}
