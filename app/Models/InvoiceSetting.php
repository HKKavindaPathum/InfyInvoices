<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSetting extends Model
{
    use HasFactory;

    protected $table = 'invoice-settings';

    protected $fillable = ['key', 'template_name', 'template_color'];

    protected $casts = [
        'key' => 'string',
        'template_name' => 'string',
        'template_color' => 'string',
    ];
}
