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
        Schema::create('tablas', function (Blueprint $table) {
            $table->id();
            $table->string('Modelo');
            $table->string('Marca');
            $table->string('Color')->nullable();

            //FOREIGN KEY STARTS
            $table->unsignedBigInteger('Cliente_id')->nullable();
            $table->foreign('Cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->unsignedBigInteger('Reparacion_id')->nullable();
            $table->foreign('Reparacion_id')->references('id')->on('reparacions')->onDelete('cascade');
            //FOREIGN KEY ENDS

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tablas');
    }
};
