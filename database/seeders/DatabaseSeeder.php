<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guide;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\Currency;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ================= Users =================
        // Admin tetap 1
        User::create([
            'name' => 'Admin Travel',
            'email' => 'admin@sistemtravel.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Guide Example',
            'email' => 'guide@sistemtravel.test',
            'password' => Hash::make('password'),
            'role' => 'guide',
        ]);

        User::create([
            'name' => 'Customer Example',
            'email' => 'customer@sistemtravel.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Guide users dummy
        User::factory(10)->create(['role' => 'guide']);

        // Customer users dummy
        User::factory(20)->create(['role' => 'customer']);

        // ================= Currency =================
        Currency::factory(5)->create();

        // ================= Destinations =================
        Destination::factory(15)->create();

        // ================= TourPackages =================
        TourPackage::factory(20)->create();

        // ================= Guides =================
        // Setiap user dengan role guide akan otomatis punya guide record
        $guideUsers = User::where('role', 'guide')->get();
        foreach ($guideUsers as $user) {
            Guide::factory()->create(['user_id' => $user->id]);
        }
    }
}
