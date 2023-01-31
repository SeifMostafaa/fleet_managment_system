<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();

            $table-> foreignId('start_station_id') -> references('id') -> on('stations') -> onDelete('restrict') -> onUpdate('restrict');
            $table-> foreignId('end_station_id') -> references('id') -> on('stations') -> onDelete('restrict') -> onUpdate('restrict');
            $table-> foreignId('bus_id') -> references('id') -> on('buses') -> onDelete('restrict') -> onUpdate('restrict');

            $table->date('trip_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
};
