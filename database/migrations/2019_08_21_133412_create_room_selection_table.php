<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomSelectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_selection', function (Blueprint $table) {
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('selection_id');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('selection_id')->references('id')->on('selections');
            $table->string('status')->nullable()->comment('Le prix total de la location');
            $table->string('total')->nullable()->default(0.00)->comment('Le prix total de la location');
            $table->string('pricing')->nullable()->comment('La tarification de la location en json');
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
        Schema::dropIfExists('room_selection');
    }
}
