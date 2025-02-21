<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UserTable extends LivewireTableComponent
{
    protected $model = User::class;

    protected string $tableName = 'users';

    protected $listeners = ['resetPageTable'];

    // for table header button
    public $showButtonOnHeader = true;

    public $buttonComponent = 'users.table-components.add-button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('page');
        $this->setDefaultSort('created_at', 'desc');
        $this->setQueryStringStatus(false);

        $this->setThAttributes(function (Column $column) {
            if ($column->getField() == 'id') {
                return [
                    'style' => 'width:9%;text-align:center',
                ];
            }

            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.common.name'), 'first_name')
                ->sortable()
                ->searchable(function (Builder $query, $direction) {
                    $query->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                })
                ->view('users.table-components.full-name'),
            Column::make(__('last_name'), 'last_name')
                ->searchable()->hideIf(1),
            Column::make(__('messages.user.email'), 'email')
                ->searchable()->hideIf(1),
            Column::make('is_default_admin', 'is_default_admin')
                ->searchable()->hideIf(1),
            Column::make(__('messages.common.action'), 'id')
                ->format(function ($value, $row, Column $column) {
                    return view('livewire.action-button')->with([
                        'editRoute' => route('users.edit', $row->id),
                        'dataId' => $row->id,
                        'row' => $row,
                        'editClass' => 'user-edit-btn',
                        'deleteClass' => 'user-delete-btn',
                        'isDefaultAdmin' => $row->is_default_admin,
                    ]);
                }),
        ];
    }

    public function builder(): Builder
    {
        return User::where('id', '!=', Auth::id())
            ->whereHas('roles', function ($q) {
                $q->where('name', Role::ROLE_ADMIN);
            })->with('media');
    }

    public function resetPageTable()
    {
        $this->customResetPage('page');
    }

    public function placeholder()
    {
        return view('livewire.listing_skeleton');
    }
}
