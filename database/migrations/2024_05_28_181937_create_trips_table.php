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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('from_governorate');
            $table->unsignedBigInteger('to_governorate');
            $table->datetime('travel_date');
            $table->string('status')->default('New');
            $table->string('type')->default('Daily');//dailly or mosame
            $table->timestamps();
            $table->softDeletes();
            // Define foreign keys
            $table->foreign('bus_id')->references('id')->on('buses')->onDelete('cascade');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};