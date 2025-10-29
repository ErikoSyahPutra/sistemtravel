<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Itinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'day_number',
        'title',
        'description',
        'start_time',
        'end_time',
        'location'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
