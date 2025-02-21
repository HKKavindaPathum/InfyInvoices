<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Column;

class InvoiceTable extends LivewireTableComponent
{
    protected $model = Invoice::class;

    protected string $tableName = 'invoices';

    public $showButtonOnHeader = true;

    public $buttonComponent = 'invoices.components.add-button';

    public bool $showFilterOnHeader = true;

    public $filterComponent = ['invoices.components.filter', Invoice::STATUS_ARR, Invoice::RECURRING_STATUS_ARR];

    public $listeners = ['changeInvoiceStatusFilter', 'changeRecurringStatusFilter', 'resetPageTable', 'changeDateFilter'];

    public $status = Invoice::STATUS_ALL;

    public $recurringStatus = '';

    public array $dateRange = [];

    protected $queryString = ['status'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setQueryStringStatus(false);

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('final_amount')) {
                return [
                    'class' => 'd-flex justify-content-end',
                ];
            }
            if ($column->isField('amount')) {
                return [
                    'class' => 'text-end',
                ];
            }

            return ['class' => 'text-center'];
        });

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if (in_array($column->getField(), ['status', 'id'])) {
                return [
                    'class' => 'text-center',
                ];
            }
            if (in_array($column->getField(), ['amount', 'final_amount'])) {
                return [
                    'class' => 'text-end',
                ];
            }

            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.invoice.client'), 'client.user.first_name')
                ->sortable()
                ->searchable()
                ->view('invoices.components.client-name'),
            Column::make('invoice_id', 'invoice_id')
                ->sortable()
                ->searchable()->hideIf(1),
            Column::make('Last Name', 'client.user.last_name')
                ->sortable()
                ->searchable()->hideIf(1),
            Column::make(__('messages.invoice.invoice_date'), 'invoice_date')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    return view('invoices.components.invoice-due-date')
                        ->withValue([
                            'invoice-date' => $row->invoice_date,
                        ]);
                }),
            Column::make(__('messages.invoice.due_date'), 'due_date')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    return view('invoices.components.invoice-due-date')
                        ->withValue([
                            'due-date' => $row->due_date,
                        ]);
                }),
            Column::make(__('messages.invoice.amount'), 'final_amount')
                ->sortable()
                ->searchable()
                ->view('invoices.components.amount'),
            Column::make(__('messages.invoice.transactions'), 'amount')
                ->searchable()
                ->view('invoices.components.transaction'),
            Column::make(__('messages.common.status'), 'status')
                ->searchable()
                ->view('invoices.components.transaction-status'),
            Column::make(__('messages.common.action'), 'id')
                ->view('livewire.invoice-action-button'),
        ];
    }

    public function builder(): Builder
    {
        $query = Invoice::with(['client.user.media', 'payments']);

         /** @var User $user */
         $user = Auth::user();
         if ($user->hasRole(Role::ROLE_CLIENT)) {
             $query->where('invoices.status', '!=', Invoice::DRAFT);
         }

        $query->when($this->status != '' && $this->status != Invoice::STATUS_ALL, function ($query) {
            $query->where('invoices.status', $this->status);
        });

        $query->when($this->recurringStatus != '', function ($query) {
            $query->where('invoices.recurring_status', $this->recurringStatus);
        });

        $query->when(count($this->dateRange) > 0, function ($query) {
            $startDate = $this->dateRange[0];
            $endDate = $this->dateRange[1];
            $query->whereBetween('invoices.invoice_date', [$startDate, $endDate]);
        });

        return $query->select('invoices.*');
    }

    public function changeInvoiceStatusFilter($status)
    {
        $this->status = $status;
        $this->setBuilder($this->builder());
    }

    public function changeRecurringStatusFilter($recurringStatus)
    {
        $this->recurringStatus = $recurringStatus;
        $this->setBuilder($this->builder());
    }

    public function changeDateFilter($startDate, $endDate)
    {
        $this->dateRange = array($startDate, $endDate);
        $this->setBuilder($this->builder());
        $this->resetPagination();
    }

    public function resetPageTable()
    {
        $this->customResetPage('invoicesPage');
    }

    public function resetPagination()
    {
        $this->resetPage('invoicesPage');
    }

    public function placeholder()
    {
        return view('livewire.invoice_listing_skeleton');
    }
}
