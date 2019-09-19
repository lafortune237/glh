<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hostels', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name')->nullable()->comment(config("Nom de l'hotel"));
            $table->longText('description')->nullable();
            $table->string('address_station')->nullable()->comment(config('dbcomments.address_station'));
            $table->decimal('address_latitude',10,8)->nullable();
            $table->decimal('address_longitude',11,8)->nullable();
            $table->string('contact')->nullable()->comment(config('dbcomments.contact'));
            $table->string('email')->nullable();
            $table->string('tel1')->nullable();
            $table->string('tel2')->nullable();
            $table->boolean('verified')->default(\App\Hostel::UNVERIFIED_HOSTEL)->comment(config('dbcomments.validated'));
            $table->integer('nbr_rental')->unsigned()->nullable()->default(0)->comment(config('dbcomments.nbr_rental'));
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
        Schema::dropIfExists('hostels');
    }
}
