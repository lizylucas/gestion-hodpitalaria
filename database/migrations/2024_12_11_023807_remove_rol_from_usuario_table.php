<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveRolFromUsuarioTable extends Migration
{
    public function up()
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->dropColumn('rol');
        });
    }

    public function down()
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->string('rol')->nullable();
        });
    }
}