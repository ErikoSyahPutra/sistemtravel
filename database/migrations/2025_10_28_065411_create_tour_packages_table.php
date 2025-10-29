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
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->bigInteger('price_minor'); // harga dalam satuan kecil (mis. sen)
            $table->string('currency', 3);
            $table->integer('duration_days');
            $table->integer('capacity');
            $table->json('images')->nullable();
            $table->json('extras')->nullable();
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
        Schema::dropIfExists('tour_packages');
    }
};
