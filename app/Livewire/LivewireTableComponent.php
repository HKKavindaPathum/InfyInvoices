<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Exceptions\DataTableConfigurationException;

/**
 * Class LivewireTableComponent
 */
class LivewireTableComponent extends DataTableComponent
{
    protected bool $columnSelectStatus = false;

    protected $listeners = ['resetPageTable', '$refresh'];

    public bool $paginationStatus = true;

    public bool $sortingPillsStatus = false;

    public bool $filterPillsStatus = false;

    public bool $showFilterOnHeader = false;

    public bool $reordering = false;

    public string $emptyMessage = ('messages.no_records_found');

    // for table header button
    public $showButtonOnHeader = false;

    public $buttonComponent = '';

    public function configure(): void
    {
        // TODO: Implement configure() method.
    }

    public function columns(): array
    {
        // TODO: Implement columns() method.
    }

    /**
     * @throws DataTableConfigurationException
     */
    //     public function mountWithPagination(): void
    //     {
    //         if ($this->paginationIsDisabled()) {
    //             return;
    //         }

    //         $this->setPerPage($this->getPerPageAccepted()[0] ?? 10);
    //     }

    public function customResetPage($pageName = 'page')
    {
        $rowsPropertyData = $this->getRows()->toArray();
        $prevPageNum = $rowsPropertyData['current_page'] - 1;
        $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
        $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

        $this->setPage($pageNum, $pageName);
    }
}
