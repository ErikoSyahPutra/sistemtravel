<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'location', 'description', 'cover_image', 'meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function tourPackages()
    {
        return $this->hasMany(TourPackage::class);
    }
}
