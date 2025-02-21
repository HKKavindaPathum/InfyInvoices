<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $table = 'taxes';

    protected $fillable = ['name', 'value', 'is_default'];

    protected $casts = [
        'name' => 'string',
        'value' => 'double',
        'is_default' => 'boolean',
    ];

    public static $rules = [
        'name' => 'required|unique:taxes,name',
        'value' => 'required|numeric',
    ];
}
