<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->unsignedBigInteger('hostel_id')->nullable();
            $table->foreign('hostel_id')->references('id')->on('hostels');
            $table->string('name')->nullable()->comment(config("Nom de la chambre"));
            $table->unsignedBigInteger('category_id')->nullable()->comment('Categorie de la chambre');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->float('price_hour')->nullable()->unsigned()->comment("Prix par heure");
            $table->float('price_night')->nullable()->unsigned()->comment('Prix par nuit');
            $table->longText('description')->nullable();
            $table->string('available')->default(\App\Room::UNAVAILABLE_ROOM)->comment(config('dbcomments.availability'));
            $table->integer('nbr_rental')->unsigned()->nullable()->default(0)->comment(config('dbcomments.nbr_rental'));
            $table->unsignedTinyInteger('nbr_beds')->nullable()->comment('Nombre de lits');
            $table->unsignedTinyInteger('nbr_people')->nullable()->comment('Nombre de personnes');
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
        Schema::dropIfExists('rooms');
    }
}
