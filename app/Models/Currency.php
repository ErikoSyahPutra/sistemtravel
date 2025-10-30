<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'rate_to_base', 'fetched_at'];

    protected $casts = [
        'fetched_at' => 'datetime',
    ];

    public $timestamps = false;
}
