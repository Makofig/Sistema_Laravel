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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cliente')
                ->constrained('cliente')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_cuota')
                ->constrained('cuotas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('num_cuotas');
            $table->float('costo');
            $table->float('abonado')->nullable();
            $table->boolean('estado');
            $table->date('fecha_pago')->nullable();
            $table->string('comentario', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
