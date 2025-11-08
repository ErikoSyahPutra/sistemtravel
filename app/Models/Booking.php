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
        'booking_number',
        'date_start',
        'date_end',
        'pax_count',
        'total_price',
        'currency',
        'status',
        'payment_method',
        'payment_status',
        'va_number',
        'payment_url',
        'paid_at',
        'total_amount',
        'meta'
    ];

    protected $casts = [
        'meta' => 'array',
        'paid_at' => 'datetime',
        'date_start' => 'date',
        'date_end' => 'date',
        'pax_count' => 'integer',
        'total_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
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

    // app/Models/Booking.php
    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class, 'package_id');
    }



    public function isPending()
    {
        return $this->payment_status === 'pending';
    }

    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function isExpired()
    {
        return $this->payment_status === 'expired' ||
            ($this->expired_at && now()->isAfter($this->expired_at));
    }
}
