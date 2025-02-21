<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\AdminPayment
 *
 * @property int $id
 * @property int $invoice_id
 * @property float $amount
 * @property string $payment_mode
 * @property string $payment_date
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Invoice $invoice
 *
 * @method static Builder|AdminPayment newModelQuery()
 * @method static Builder|AdminPayment newQuery()
 * @method static Builder|AdminPayment query()
 * @method static Builder|AdminPayment whereAmount($value)
 * @method static Builder|AdminPayment whereCreatedAt($value)
 * @method static Builder|AdminPayment whereId($value)
 * @method static Builder|AdminPayment whereInvoiceId($value)
 * @method static Builder|AdminPayment whereNotes($value)
 * @method static Builder|AdminPayment wherePaymentDate($value)
 * @method static Builder|AdminPayment wherePaymentMode($value)
 * @method static Builder|AdminPayment whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class AdminPayment extends Model
{
    /**
     * @var string
     */
    protected $table = 'admin_payments';

    /**
     * @var string[]
     */
    protected $fillable = ['invoice_id', 'amount', 'payment_date', 'payment_id', 'payment_mode', 'notes'];

    /**
     * @var string[]
     */
    public static $rules = [
        'invoice_id' => 'required',
        'amount' => 'required',
        'payment_mode' => 'required',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'invoice_id' => 'integer',
        'amount' => 'double',
        'payment_mode' => 'integer',
        'payment_id' => 'integer',
        'payment_date' => 'date',
        'notes' => 'string',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}
