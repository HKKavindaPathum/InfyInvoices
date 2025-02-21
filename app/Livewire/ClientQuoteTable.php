<?php

namespace App\Livewire;

use App\Models\Quote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ClientQuoteTable extends LivewireTableComponent
{
    protected $model = Quote::class;

    protected string $tableName = 'quotes';

    public $showButtonOnHeader = true;

    public $buttonComponent = 'client_panel.quotes.components.add-button';

    public bool $showFilterOnHeader = true;

    public $filterComponent = ['quotes.components.filter', Quote::STATUS_ARR];

    public $listeners = ['changeQuoteStatusFilter', 'resetPageTable','changeDateRangeFilter'];

    public $status = Quote::STATUS_ALL;

    public array $dateRange = [];

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

            return [
                'class' => 'text-center',
            ];
        });

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if (in_array($column->getField(), ['amount', 'status', 'id'])) {
                return [
                    'class' => 'text-center',
                ];
            }
            if ($column->getField() == 'final_amount') {
                return [
                    'class' => 'text-end',
                ];
            }

            return [
            ];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.quote.quote_id'), 'client.user.first_name')
                ->sortable()
                ->searchable()
                ->view('client_panel.quotes.components.quote-id'),
            Column::make('quote_id', 'quote_id')
                ->sortable()
                ->searchable()->hideIf(1),
            Column::make('Last Name', 'client.user.last_name')
                ->sortable()
                ->searchable()->hideIf(1),
            Column::make(__('messages.quote.quote_date'), 'quote_date')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    return view('quotes.components.quote-due-date')
                        ->withValue([
                            'quote-date' => $row->quote_date,
                        ]);
                }),
            Column::make(__('messages.quote.due_date'), 'due_date')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    return view('quotes.components.quote-due-date')
                        ->withValue([
                            'due-date' => $row->due_date,
                        ]);
                }),
            Column::make(__('messages.quote.amount'), 'final_amount')
                ->sortable()
                ->searchable()
                ->view('quotes.components.amount'),
            Column::make(__('messages.common.status'), 'status')
                ->searchable()
                ->view('quotes.components.quote-status'),
            Column::make(__('messages.common.action'), 'id')
                ->view('livewire.client-quote-action-button'),
        ];
    }

    public function builder(): Builder
    {
        $clientId = Auth::user()->client->id;
        $query = Quote::with(['client.user.media'])->where('client_id', $clientId);

        $query->when($this->status != Quote::STATUS_ALL, function ($query) {
            $query->where('quotes.status', $this->status);
        });

        $query->when(count($this->dateRange) > 0, function ($query) {
            $startDate = $this->dateRange[0];
            $endDate = $this->dateRange[1];
            $query->whereBetween('quotes.quote_date', [$startDate, $endDate]);
        });

        return $query->select('quotes.*');
    }

    public function changeQuoteStatusFilter($status)
    {
        $this->status = $status;
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
        $this->customResetPage('quotesPage');
    }

    public function resetPagination()
    {
        $this->resetPage('quotesPage');
    }

    public function placeholder()
    {
        return view('livewire.invoice_listing_skeleton');
    }
}
