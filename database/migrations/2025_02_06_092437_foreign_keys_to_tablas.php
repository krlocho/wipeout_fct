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
        Schema::table('tablas', function (Blueprint $table) {
            //

            $table->bigInteger('User_id')->unsigned()->nullable();
            $table->foreign('User_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tablas', function (Blueprint $table) {
            //

            $table->dropForeign(['User_id']);
        });
    }
};
