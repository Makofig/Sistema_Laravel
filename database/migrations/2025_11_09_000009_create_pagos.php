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

            // Relaciones
            $table->foreignId('id_cliente')->nullable()->constrained('cliente')->onDelete('set null');
            $table->foreignId('id_cuota')->nullable()->constrained('cuotas')->onDelete('set null');

            // Datos
            $table->integer('num_cuotas')->default(1);
            $table->decimal('costo', 8, 2)->default(0);
            $table->decimal('abonado', 8, 2)->default(0);
            $table->boolean('estado')->default(0); // 0: pendiente, 1: pagado
            $table->date('fecha_pago')->nullable();
            $table->string('comentario')->nullable();
            $table->string('image')->nullable();
            $table->string('image2')->nullable();
            
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
