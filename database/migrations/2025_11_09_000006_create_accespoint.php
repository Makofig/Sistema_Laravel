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
        Schema::create('accespoint', function (Blueprint $table) {
            $table->id();
            
            $table->string('ssid');
            $table->string('frecuencia');
            $table->string('ip_ap')->nullable(); // por si el IP puede ser opcional
            $table->string('localidad')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accespoint');
    }
};
