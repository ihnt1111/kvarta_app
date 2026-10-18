<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'interest',
        'comment',
        'source',
    ];

    protected $casts = [
        'source' => 'array',
    ];
}
