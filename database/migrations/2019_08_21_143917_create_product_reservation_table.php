<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reservation', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('reservation_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('reservation_id')->references('id')->on('reservations');
            $table->float('total')->nullable()->default(0.00)->unsigned()->comment('Le prix total de la location');
            $table->float('gain')->nullable()->default(0.00)->unsigned()->comment('Le gain du propriétaire');
            $table->string('pricing')->nullable()->comment('La tarification de la location en json');
            $table->string('status')->nullable()->comment("Détermine l'état de la sélection (demande, location,)");
            $table->string('state')->nullable()->comment(config('dbcomments.status'));

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
        Schema::dropIfExists('product_reservation');
    }
}
