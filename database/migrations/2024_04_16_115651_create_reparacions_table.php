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
        Schema::create('reparacions', function (Blueprint $table) {
            $table->id();
            $table->string('Reparacion');
            $table->integer('Precio')->nullable();
            $table->date('Fecha_llegada');
            $table->date('Fecha_salida')->nullable();
            $table->string('Estado')->default('Pendiente');
            $table->string('Observaciones')->nullable();





            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reparacions');
    }
};
