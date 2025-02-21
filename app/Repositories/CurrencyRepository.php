<?php

namespace App\Repositories;

use App\Models\Currency;

/**
 * Class CurrencyRepository
 */
class CurrencyRepository extends BaseRepository
{
    public $fieldSearchable = [
        'name',
    ];

    /**
     * @return array|string[]
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Currency::class;
    }
}
