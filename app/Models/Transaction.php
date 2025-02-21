<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $transactionData)
 */
class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    public $fillable = ['transaction_id', 'amount', 'user_id', 'status', 'meta'];

    protected $casts = [
        'transaction_id' => 'string',
        'amount' => 'double',
        'user_id' => 'integer',
        'meta' => 'json',
        'status' => 'integer',
    ];
}
