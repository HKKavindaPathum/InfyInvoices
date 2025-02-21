<?php

namespace App\Livewire;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class TransactionTable extends LivewireTableComponent
{
    protected $model = Payment::class;

    protected string $tableName = 'payments';

    public bool $showFilterOnHeader = true;

    public $filterComponent = ['transactions.components.filter_and_export', Payment::PAYMENT_MODE, Payment::PAYMENT_STATUS];

    protected $listeners = ['changePaymentModeFilter', 'changePaymentStatusFilter', 'resetPageTable','changeDateRangeFilter'];

    public $paymentModeFilter = Payment::ALL;

    public $paymentStatusFilter = Payment::STATUS_ALL;

    public array $dateRange = [];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setQueryStringStatus(false);

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('payment_mode')) {
                return [
                    'class' => 'text-center w-12',
                ];
            }
            if ($column->isField('first_name')) {
                return [
                    'class' => 'w-35',
                ];
            }
            if ($column->isField('amount')) {
                return [
                    'class' => 'd-flex justify-content-end w-15',
                ];
            }
            if ($column->isField('id')) {
                return [
                    'class' => 'text-center',
                ];
            }

            return [];
        });

        $this->setTdAttributes(function (Column $column) {
            if ($column->getField() === 'payment_mode') {
                return [
                    'class' => 'text-center',
                ];
            }

            if ($column->getField() === 'amount') {
                return [
                    'class' => 'text-end',
                ];
            }
            if ($column->getField() === 'id') {
                return [
                    'class' => 'text-center',
                ];
            }

            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.payment.transaction_id'), 'transaction_id')
                ->searchable()
                ->view('transactions.components.transactions-id'),
            Column::make(__('messages.invoice.invoice_id'), 'invoice.invoice_id')
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    return view('transactions.components.invoice-id-payment-date')
                        ->withValue([
                            'invoice-id-route' => route('invoices.show', $row->invoice->id),
                            'invoice-id' => $row->invoice->invoice_id,
                        ]);
                }),
            Column::make(__('messages.invoice.client'), 'invoice.client.user.first_name')
//                ->sortable()
                ->searchable()
                ->view('transactions.components.client-name'),
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
                ->view('transactions.components.amount'),
            Column::make(__('messages.setting.payment_approved'), 'payment_mode')
                ->searchable()
                ->view('transactions.components.transaction-approved'),
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
        $query = Payment::with('invoice.client.user');

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

        $query->when(count($this->dateRange) > 0, function (Builder $q) {
            $startDate = $this->dateRange[0];
            $endDate = $this->dateRange[1];
            $q->whereBetween('payment_date', [$startDate, $endDate]);
        });

        return $query->select('payments.*');
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

    public function changeDateRangeFilter($startDate, $endDate)
    {
        $this->dateRange = [$startDate, $endDate];
        $this->setBuilder($this->builder());
        $this->resetPagination();
    }

    public function resetPageTable()
    {
        $this->customResetPage('paymentsPage');
    }

    public function resetPagination()
    {
        $this->resetPage('paymentsPage');
    }

    public function placeholder()
    {
        return view('livewire.transaction_listing_skeleton');
    }
}
