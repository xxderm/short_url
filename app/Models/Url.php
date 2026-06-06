<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = [
        'url',
        'code',
        'clicks'
    ];

    protected $casts = [
        'clicks' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ]
}
