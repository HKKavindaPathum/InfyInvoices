<?php

namespace App\Repositories;

use App\Mail\CreateNewClientMail;
use App\Models\Client;
use App\Models\Country;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class ClientRepository
 *
 * @version August 6, 2021, 10:17 am UTC
 */
class ClientRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'website',
        'address',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return Client::class;
    }

    public function getData(): mixed
    {
        $data['countries'] = Country::toBase()->pluck('name', 'id')->toArray();

        return $data;
    }

    public function store($input): bool
    {
        try {
            DB::beginTransaction();

            // $input['client_password'] = $input['password'];
            // $input['password'] = Hash::make($input['password']);

            // Set a default password if not provided
            if (empty($input['password'])) {
                $input['password'] = Hash::make('default_password'); // Set a default password
                $input['client_password'] = 'default_password'; // Set the client_password key
            } else {
                $input['password'] = Hash::make($input['password']);
                $input['client_password'] = $input['password']; // Set the client_password key
            }

            $input['language'] = getDefaultLanguage();

            if (isset($input['contact'])) {
                $checkUniqueness = checkContactUniqueness($input['contact'], $input['region_code']);
                if ($checkUniqueness) {
                    throw new UnprocessableEntityHttpException('Contact number already exists for another Client.');
                }
            }

            /** @var User $user */
            $user = User::create($input);
            $user->assignRole(Role::ROLE_CLIENT);

            $input['user_id'] = $user->id;
            $client = Client::create($input);

            if (isset($input['profile']) && ! empty($input['profile'])) {
                $user->addMedia($input['profile'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }
            if ($input['avatar_remove'] == 1 && isset($input['avatar_remove']) && empty($input['profile'])) {
                $user->clearMediaCollection(User::PROFILE);
                $user->media()->delete();
            }
            if (getSettingValue('mail_notification')) {
                Mail::to($input['email'])->send(new CreateNewClientMail($input));
            }
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    // public function store($input): bool
    // {
    //     try {
    //         DB::beginTransaction();
    
    //         // Set a default password if not provided
    //         if (empty($input['password'])) {
    //             $input['password'] = Hash::make('default_password'); // Set a default password
    //             $input['client_password'] = 'default_password'; // Set the client_password key
    //         } else {
    //             $input['password'] = Hash::make($input['password']);
    //             $input['client_password'] = $input['password']; // Set the client_password key
    //         }
    
    //         $input['language'] = getDefaultLanguage();
    
    //         if (isset($input['contact'])) {
    //             $checkUniqueness = checkContactUniqueness($input['contact'], $input['region_code']);
    //             if ($checkUniqueness) {
    //                 throw new UnprocessableEntityHttpException('Contact number already exists for another Client.');
    //             }
    //         }
    
    //         $user = User::create($input);
    //         $user->assignRole(Role::ROLE_CLIENT);
    
    //         $input['user_id'] = $user->id;
    //         $client = Client::create($input);
    
    //         if (isset($input['profile']) && !empty($input['profile'])) {
    //             $user->addMedia($input['profile'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
    //         }
    
    //         if ($input['avatar_remove'] == 1 && isset($input['avatar_remove']) && empty($input['profile'])) {
    //             $user->clearMediaCollection(User::PROFILE);
    //             $user->media()->delete();
    //         }
    
    //         // Ensure client_password is set before sending the email
    //         if (getSettingValue('mail_notification')) {
    //             Mail::to($input['email'])->send(new CreateNewClientMail($input));
    //         }
    
    //         DB::commit();
    //         return true;
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         throw new UnprocessableEntityHttpException($e->getMessage());
    //     }
    // }

    public function updateClient(array $input, Client $client): bool
    {
        try {
            DB::beginTransaction();
            $user = $client->user;
            if (isset($input['password']) && ! empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input['password'] = $client->user->password;
            }

            $user->update($input);
            $client->update($input);

            if (isset($input['profile']) && ! empty($input['profile'])) {
                $user->clearMediaCollection(User::PROFILE);
                $user->media()->delete();
                $user->addMedia($input['profile'])->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }
            if ($input['avatar_remove'] == 1 && isset($input['avatar_remove']) && empty($input['profile'])) {
                $user->clearMediaCollection(User::PROFILE);
                $user->media()->delete();
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
