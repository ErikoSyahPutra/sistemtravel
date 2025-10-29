<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'languages',
        'bio',
        'available',
        'rating_cache'
    ];

    protected $casts = [
        'languages' => 'array',
        'available' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignments()
    {
        return $this->hasMany(GuideAssignment::class);
    }
}
