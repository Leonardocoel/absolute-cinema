<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained();
            $table->foreignId('user_account_id')->constrained()->onDelete('set null');
            $table->foreignId('session_schedule_id')->constrained();
            $table->foreignId('seat_id')->constrained()->onDelete('set null');
            $table->decimal('price', 19, 4)->unsigned();
            $table->boolean('is_half');
            $table->timestamps();
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
