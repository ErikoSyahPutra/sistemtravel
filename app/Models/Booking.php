<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'date_start',
        'date_end',
        'pax_count',
        'total_price_minor',
        'currency',
        'status',
        'payment_method',
        'payment_status',
        'meta'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }

    public function guideAssignments()
    {
        return $this->hasMany(GuideAssignment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
