<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Setting
 *
 * @property mixed $media
 * @property mixed $value
 * @property int $id
 * @property string $key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed|string $logo_url
 * @property-read int|null $media_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 *
 * @mixin \Eloquent
 */
class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $table = 'settings';

    const PATH = 'settings';

    const DEFAULT_TEMPLATE = 1;

    const CURRENCY_AFTER_AMOUNT = 1;

    const PAYMENT_AUTO_APPROVED = 1;

    const INVOICE__TEMPLATE_ARRAY = [
        'defaultTemplate' => 'Default',
        'newYorkTemplate' => 'New York',
        'torontoTemplate' => 'Toronto',
        'rioTemplate' => 'Rio',
        'londonTemplate' => 'London',
        'istanbulTemplate' => 'Istanbul',
        'mumbaiTemplate' => 'Mumbai',
        'hongKongTemplate' => 'Hong Kong',
        'tokyoTemplate' => 'Tokyo',
        'parisTemplate' => 'Paris',
    ];

    const DateFormatArray = [
        'd-m-Y' => 'DD-MM-YYYY',
        'm-d-Y' => 'MM-DD-YYYY',
        'Y-m-d' => 'YYYY-MM-DD',
        'm/d/Y' => 'MM/DD/YYYY',
        'd/m/Y' => 'DD/MM/YYYY',
        'Y/m/d' => 'YYYY/MM/DD',
        'm.d.Y' => 'MM.DD.YYYY',
        'd.m.Y' => 'DD.MM.YYYY',
        'Y.m.d' => 'YYYY.MM.DD',
    ];

    public $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'key' => 'string',
        'value' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'app_name' => 'string',
        'company_name' => 'string',
        'app_logo' => 'nullable|mimes:jpg,jpeg,png',
        'company_logo' => 'nullable|mimes:jpg,jpeg,png',
        'stripe_key' => 'nullable',
        'stripe_secret' => 'nullable',
        'paypal_client_id' => 'nullable',
        'paypal_secret' => 'nullable',
        'razorpay_key' => 'nullable',
        'razorpay_secret' => 'nullable',
        'country' => 'nullable|required_with:show_additional_address_in_invoice',
        'state' => 'nullable|required_with:show_additional_address_in_invoice',
        'city' => 'nullable|required_with:show_additional_address_in_invoice',
        'zipcode' => 'nullable|required_with:show_additional_address_in_invoice',
        'fax_no' => 'nullable|required_with:show_additional_address_in_invoice',
        'gst_no' => 'nullable|alpha_num|size:15',
    ];

    public function getLogoUrlAttribute(): string
    {
        /** @var Media $media */
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset('assets/images/infyom.png');
    }
}
