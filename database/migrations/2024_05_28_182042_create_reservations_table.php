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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('traveler_id');
            $table->integer('seat_number');
            $table->date('reservation_date');
            $table->integer('status')->default(1);
            $table->integer('total')->default(0);
            $table->timestamps();
            $table->softDeletes();
            // Define foreign keys
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->foreign('traveler_id')->references('id')->on('travelers')->onDelete('cascade');
      
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};