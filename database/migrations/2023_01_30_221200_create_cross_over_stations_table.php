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
        Schema::create('cross_over_stations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trip_id') -> references('id') -> on('trips') -> onDelete('restrict') -> onUpdate('restrict');
            $table->foreignId('start_station_id') -> references('id') -> on('stations') -> onDelete('restrict') -> onUpdate('restrict');
            $table->foreignId('end_station_id') -> references('id') -> on('stations') -> onDelete('restrict') -> onUpdate('restrict');

            $table->integer('station_order');
            $table->integer('available_seats');

            $table->index(['start_station_id', 'end_station_id']);

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
        Schema::dropIfExists('cross_over_stations');
    }
};
