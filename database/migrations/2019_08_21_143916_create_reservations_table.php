<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('address_station')->nullable()->comment('Localisation de la location');
            $table->decimal('address_latitude',10,8)->nullable();
            $table->decimal('address_longitude',11,8)->nullable();
            $table->dateTime('request_date_start')->nullable()->comment('Date de début de la location');
            $table->dateTime('request_date_end')->nullable()->comment('Date de fin de la location');
            $table->integer('nbr_days')->nullable()->comment("Nombre de jours");
            $table->integer('nbr_hours')->nullable()->comment("Nombre d'heures");

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
        Schema::dropIfExists('selections');
    }
}
