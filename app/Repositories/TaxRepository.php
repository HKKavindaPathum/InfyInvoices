<?php

namespace App\Repositories;

use App\Models\Tax;

/**
 * Class TaxRepository
 */
class TaxRepository extends BaseRepository
{
    public $fieldSearchable = [
        'name',
    ];

    /**
     * {@inheritDoc}
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return Tax::class;
    }
}
