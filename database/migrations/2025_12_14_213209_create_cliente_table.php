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
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_plan')
                ->constrained('plan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_point')
                ->constrained('accesspoint')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('nombre', 150);
            $table->string('apellido', 50);
            $table->string('direccion', 255);
            $table->string('telefono', 20)->nullable();
            $table->string('ip', 15)->nullable();
            $table->string('imagen', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
