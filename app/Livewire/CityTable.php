<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\City;
use App\Models\State;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CityTable extends LivewireTableComponent
{
    protected $model = City::class;

    protected string $tableName = 'cities';

    public $showButtonOnHeader = true;

    protected $listeners = ['refresh' => '$refresh', 'resetPageTable'];

    public $buttonComponent = 'cities.add-button';

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
                })->searchable()->view('cities/columns/state_name'),
            Column::make(__('messages.common.action'), 'id')
                ->view('cities/columns/action'),
        ];
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
        return view('livewire.listing_skeleton');
    }
}
