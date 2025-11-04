<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('package_id')->constrained('tour_packages')->onDelete('cascade');
            $table->string('booking_number');
            $table->date('date_start');
            $table->date('date_end');
            $table->integer('pax_count');
            $table->bigInteger('total_price');
            $table->string('currency', 3);
            $table->string('status')->default('pending'); // pending, confirmed, cancelled
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->string('va_number')->nullable();
            $table->string('payment_url')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->bigInteger('total_amount');
            $table->json('meta')->nullable();
            $table->timestamps();

            // 🔗 relasi ke tabel currencies (kode ISO-3)
            $table->foreign('currency')->references('code')->on('currencies')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
