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
            $table->string('date');
            $table->unsignedBigInteger('slot_id');
            $table->string('customer_name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('vehicle_model');
            $table->tinyInteger('status')->default(0); // Assuming default status is 0
            $table->timestamps();
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
