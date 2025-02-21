<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Eloquent\Builder;
use App\Livewire\LivewireTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;


class CityTable extends LivewireTableComponent
{
    protected $model = City::class;

    public bool $showButtonOnHeader = true;

    public
     $buttonComponent = 'sadmin.cities.add-button';

    protected $listeners = ['refresh' => '$refresh', 'resetPageTable'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('city-table');
        $this->setDefaultSort('created_at', 'desc');
        $this->setColumnSelectStatus(false);
        $this->setQueryStringStatus(false);
        $this->resetPage('city-table');

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('id')) {
                return [
                    'class' => 'd-flex justify-content-center',
                ];
            }
            return [];
        });
    }
    public function columns(): array
    {
        return [
            Column::make(__('messages.city.city_name'), 'name')
                ->sortable()->searchable(),
            Column::make(__('messages.city.state_name'), 'state_id')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(
                        State::select('name')
                            ->whereColumn('cities.state_id', 'states.id'),
                        $direction
                    );
                })->searchable()->view('sadmin/cities/columns/state_name'),
            Column::make(__('messages.common.action'), 'id')
                ->view('sadmin/cities/columns/action'),
        ];
    }
    public function builder(): Builder
    {
        return City::with('state')->select('cities.*');
    }

    public function resetPageTable($pageName = 'city-table')
    {
        $rowsPropertyData = $this->getRows()->toArray();
        $prevPageNum = $rowsPropertyData['current_page'] - 1;
        $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
        $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

        $this->setPage($pageNum, $pageName);
    }
    public function placeholder()
    {
        return view('lazy_loading.without-filter-skelecton');
    }
}
