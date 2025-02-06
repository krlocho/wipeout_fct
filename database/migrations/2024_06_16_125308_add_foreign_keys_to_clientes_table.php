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
        Schema::table('clientes', function (Blueprint $table) {
            //FOREIGN KEY STARTS
            $table->unsignedBigInteger('Tabla_id')->nullable();
            $table->foreign('Tabla_id')->references('id')->on('tablas')->onDelete('cascade');
            $table->unsignedBigInteger('Reparacion_id')->nullable();
            $table->foreign('Reparacion_id')->references('id')->on('reparacions')->onDelete('cascade');
            $table->bigInteger('User_id')->unsigned()->nullable();
            $table->foreign('User_id')->references('id')->on('users')->onDelete('cascade');


            //FOREIGN KEY ENDS
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign(['Tabla_id']);
            $table->dropForeign(['Reparacion_id']);
            $table->dropForeign(['User_id']);
        });
    }
};
