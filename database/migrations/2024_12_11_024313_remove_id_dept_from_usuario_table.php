<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveIdDeptFromUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->dropForeign(['id_dept']); // Si es una clave foránea
            $table->dropColumn('id_dept');    // Eliminar la columna
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->foreignId('id_dept')->constrained('departamento'); // Restaurar el campo
        });
    }
}