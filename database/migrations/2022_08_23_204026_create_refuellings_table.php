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
        Schema::create('refuellings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fleet_id');
            $table->foreign('fleet_id')->references('id')->on('fleets');
            $table->float('machine_hours', 8, 2, true); 
            $table->float('fuel_added', 8, 2, true); // in Liters
            $table->string('location');
            $table->boolean('isTankFilled')->default(false);
            $table->date('date')->useCurrent();
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
        Schema::dropIfExists('refuellings');
    }
};
