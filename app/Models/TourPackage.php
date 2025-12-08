<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourPackage extends Model
{
    use HasFactory;
    protected $fillable = [
        'destination_id',
        'title',
        'slug',
        'description',
        'price',
        'currency',
        'duration_days',
        'capacity',
        'images',
        'extras'
    ];

    public function itineraries(): HasMany
    {
        return $this->hasMany(Itinerary::class, 'package_id');
    }
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

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'package_id');
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class, 'package_id');
    }
}
