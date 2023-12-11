<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('cinemas', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->char('cnpj', 18)->unique();
            $table->char('state', 2);
            $table->string('city');
            $table->string('address');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cinemas');
    }
};
