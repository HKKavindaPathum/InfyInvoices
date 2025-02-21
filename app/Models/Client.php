<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Support\Str;

/**
 * App\Models\Client
 *
 * @property int $id
 * @property int $user_id
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property string $postal_code
 * @property string|null $website
 * @property string $address
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereWebsite($value)
 * @property bool|null $is_password_set
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Invoice> $invoices
 * @property-read int|null $invoices_count
 * @property-read \App\Models\State|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereIsPasswordSet($value)
 * @property string|null $vat_no
 * @property string|null $company_name
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereVatNo($value)
 * @mixin Eloquent
 */
class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    public $fillable = [
        'user_id',
        'website',
        'postal_code',
        'address',
        'note',
        'country_id',
        'state_id',
        'city_id',
        'is_password_set',
        'vat_no',
        'company_name',
    ];

    protected $casts = [
        'website' => 'string',
        'postal_code' => 'string',
        'address' => 'string',
        'note' => 'string',
        'country_id' => 'integer',
        'state_id' => 'integer',
        'city_id' => 'integer',
        'user_id' => 'integer',
        'is_password_set' => 'boolean',
        'vat_no' => 'string',
        'company_name' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email:filter|unique:users,email',
        // 'password' => 'required|same:password_confirmation|min:6',
        'password' => 'nullable|same:password_confirmation|min:6',
        'postal_code' => 'required|string',
        'address' => 'nullable|string',
        'website' => 'nullable|url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Generate a unique email in the format numbers@test.com.
     *
     * @return string
     */
    public static function generateUniqueEmail(): string
    {
        do {
            // Generate a random 9-digit number
            $numericPart = mt_rand(100000000, 999999999);
            $email = $numericPart . '@test.com';

            // Check if the email already exists in the users table
            $isExist = User::where('email', $email)->exists();
        } while ($isExist); // Keep generating until a unique email is found

        return $email;
    }

}
