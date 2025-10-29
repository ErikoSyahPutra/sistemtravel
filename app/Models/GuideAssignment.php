<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuideAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_id',
        'booking_id',
        'assigned_by',
        'status',
        'notes'
    ];

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
