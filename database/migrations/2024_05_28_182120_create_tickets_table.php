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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('reservation_id');
             $table->unsignedBigInteger('service_id');
           
            $table->integer('seat_number');
            $table->integer('price');
            $table->integer('tiket_number');
             $table->date('travel_date');
             $table->integer('status')->default(1);
             $table->timestamps();
             $table->softDeletes();
            // Define foreign keys
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};