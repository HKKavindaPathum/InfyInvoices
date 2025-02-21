<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $category_id
 * @property string $unit_price
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read string $product_image
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
 *     $notifications
 * @property-read int|null $notifications_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Product extends Model implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;

    protected $table = 'products';

    protected $fillable = ['name', 'code', 'category_id', 'unit_price', 'description'];

    protected $casts = [
        'name' => 'string',
        'code' => 'string',
        'category_id' => 'integer',
        'unit_price' => 'double',
        'description' => 'string',
    ];

    const Image = 'product';

    protected $appends = ['product_image'];

    public static $rules = [
        'name' => 'required',
        'code' => 'required|alpha_num|min:3|max:6|unique:products,code',
        'category_id' => 'required',
        'unit_price' => 'required|numeric',
    ];

    public static $messages = [
        'code.required' => 'The product code field is required.',
        'code.size' => 'The product code must be 6 characters.',
        'code.unique' => 'The product code has already been taken.',
    ];

    public function getProductImageAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::Image)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset('images/default-product.jpg');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
