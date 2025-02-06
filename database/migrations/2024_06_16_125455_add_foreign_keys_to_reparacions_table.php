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
        Schema::table('reparacions', function (Blueprint $table) {
            //FOREIGN KEY STARTS
            $table->bigInteger('Cliente_id')->unsigned()->nullable();
            $table->bigInteger('Tabla_id')->unsigned()->nullable();
            $table->bigInteger('User_id')->unsigned()->nullable();

            $table->foreign('Cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('Tabla_id')->references('id')->on('tablas')->onDelete('cascade');
            $table->foreign('User_id')->references('id')->on('users')->onDelete('cascade');
            //FOREIGN KEY ENDS
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reparacions', function (Blueprint $table) {
            $table->dropForeign(['Tabla_id']);
            $table->dropForeign(['Reparacion_id']);
            $table->dropForeign(['User_id']);
        });
    }
};
