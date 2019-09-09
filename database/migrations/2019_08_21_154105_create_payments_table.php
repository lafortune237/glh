<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reservation_id');
            $table->foreign('reservation_id')->references('id')->on('reservations');
            $table->string('account_owner')->nullable()->comment('Nom et prénom ou raison sociale sur la carte bancaire');
            $table->string('account_nbr')->nullable()->comment('Numéro de carte bancaire');
            $table->date('expiration_date')->nullable()->comment('Date d\'expiration de la carte bancaire');
            $table->string('security_code')->nullable()->comment('Code de sécurité à 3 chiffres de la carte bancaire');
            $table->float('total')->nullable()->unsigned()->comment('Total payé');
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
        Schema::dropIfExists('payments');
    }
}
