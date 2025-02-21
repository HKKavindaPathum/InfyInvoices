<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class UserRepository
 */
class UserRepository extends BaseRepository
{
    public $fieldSearchable = [
        'first_name',
        'last_name',
        'email',
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
        return User::class;
    }

    public function store($input): bool
    {
        try {
            DB::beginTransaction();

            if (isset($input['contact'])) {
                $checkUniqueness = checkContactUniqueness($input['contact'], $input['region_code']);
                if ($checkUniqueness) {
                    throw new UnprocessableEntityHttpException('Contact number already exists for another Admin.');
                }
            }

            $input['password'] = Hash::make($input['password']);
            $input['language'] = getDefaultLanguage();
            $user = User::create($input);
            $user->assignRole(Role::ROLE_ADMIN);

            if (isset($input['profile']) && ! empty($input['profile'])) {
                $user->addMedia($input['profile'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function updateUser(array $input, int $id): bool
    {
        try {
            DB::beginTransaction();

            if (isset($input['contact'])) {
                $checkUniqueness = checkContactUniqueness($input['contact'], $input['region_code'], $id);
                if ($checkUniqueness) {
                    throw new UnprocessableEntityHttpException('Contact number already exists for another Admin.');
                }
            }

            $user = User::find($id);

            if (! empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            }

            $user->update($input);

            if (isset($input['profile']) && ! empty($input['profile'])) {
                $user->clearMediaCollection(User::PROFILE);
                $user->media()->delete();
                $user->addMedia($input['profile'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function updateProfile(array $userInput): bool
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $user->update($userInput);

            if ((! empty($userInput['image']))) {
                $user->clearMediaCollection(User::PROFILE);
                $user->media()->delete();
                $user->addMedia($userInput['image'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
