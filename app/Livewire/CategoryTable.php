<?php

namespace App\Livewire;

use App\Models\Category;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;

class CategoryTable extends LivewireTableComponent
{
    protected $model = Category::class;

    protected string $tableName = 'categories';

    // for table header button
    public $showButtonOnHeader = true;

    public $buttonComponent = 'category.components.add-button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setQueryStringStatus(false);

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if (in_array($column->getField(), ['name'])) {
                return [
                    'class' => 'w-75',
                ];
            }

            return [];
        });

        $this->setThAttributes(function (Column $column) {
            if ($column->getField() == 'id') {
                return [
                    'style' => 'width:9%;text-align:center',
                ];
            }

            return [
                'class' => 'text-center',
            ];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.category.category'), 'name')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.product.product'))
                ->label(fn($row) => $row->products_count)
                ->sortable(fn(Builder $query, string $direction) => $query->orderBy('products_count', $direction))
                ->format(function ($value, $row, Column $column) {
                    return $row->products_count;
                }),
            Column::make(__('messages.common.action'), 'id')
                ->format(function ($value, $row, Column $column) {
                    return view('livewire.modal-action-button')
                        ->with([
                            'dataId' => $row->id,
                            'editClass' => 'category-edit-btn',
                            'deleteClass' => 'category-delete-btn',
                        ]);
                }),
        ];
    }

    public function builder(): Builder
    {
        return Category::query()->withCount('products');
    }

    public function resetPageTable()
    {
        $this->customResetPage('categoriesPage');
    }

    public function placeholder()
    {
        return view('livewire.listing_skeleton');
    }
}
