<?php

namespace App\Repositories;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class UserRepository
 */
class CategoryRepository extends BaseRepository
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
        return Category::class;
    }

    public function store($input): bool
    {
        try {
            DB::beginTransaction();

            $category = Category::create($input);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function updateCategory(array $input, int $id): bool
    {
        try {
            DB::beginTransaction();

            $category = Category::find($id);
            $category->update($input);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
