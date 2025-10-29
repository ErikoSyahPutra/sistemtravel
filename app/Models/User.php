<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang bisa diisi (mass assignable).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'profile_photo',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi (misalnya saat kirim ke API).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data kolom tertentu.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke tabel bookings (1 user bisa punya banyak booking).
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Relasi ke tabel guide (jika user adalah guide).
     */
    public function guide()
    {
        return $this->hasOne(Guide::class);
    }

    /**
     * Relasi ke tabel guide_assignments (user yang assign guide).
     */
    public function assignedGuides()
    {
        return $this->hasMany(GuideAssignment::class, 'assigned_by');
    }
}
