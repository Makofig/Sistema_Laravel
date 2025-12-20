<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cliente', function (Blueprint $table) {

            // Email
            if (!Schema::hasColumn('cliente', 'email')) {
                $table->string('email')->nullable()->unique()->after('apellido');
            }

            // Columnas obligatorias
            $table->string('nombre')->nullable(false)->change();
            $table->string('apellido')->nullable(false)->change();
            $table->string('direccion')->nullable(false)->change();
        });

        // Índice UNIQUE para IP (SEPARADO)
        Schema::table('cliente', function (Blueprint $table) {
            $table->unique('ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cliente', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->dropUnique(['ip']);
        });
    }
};
