<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TourPackage extends Model
{
    use HasFactory;
    protected $fillable = [
        'destination_id',
        'title',
        'slug',
        'description',
        'price_minor',
        'currency',
        'duration_days',
        'capacity',
        'images',
        'extras'
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function availabilities()
    {
        return $this->hasMany(PackageAvailability::class, 'package_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'package_id');
    }

    public function currencyRef()
    {
        return $this->belongsTo(Currency::class, 'currency', 'code');
    }
}
