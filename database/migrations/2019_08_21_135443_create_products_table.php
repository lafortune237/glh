<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Product;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('category_id')->nullable()->comment('Categorie du produit');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->float('price_night')->nullable()->unsigned()->comment('Prix par nuit');
            $table->string('subject')->nullable()->comment(config('dbcomments.subject')); //categorie
            $table->longText('description')->nullable();
            $table->string('address_station')->nullable()->comment(config('dbcomments.address_station'));
            $table->decimal('address_latitude',10,8)->nullable();
            $table->decimal('address_longitude',11,8)->nullable();
            $table->string('contact')->nullable()->comment(config('dbcomments.contact'));
            $table->boolean('verified')->default(Product::UNVERIFIED_PRODUCT)->comment(config('dbcomments.validated'));
            $table->string('available')->default(Product::UNAVAILABLE_PRODUCT)->comment(config('dbcomments.availability'));
            $table->integer('nbr_rental')->unsigned()->nullable()->default(0)->comment(config('dbcomments.nbr_rental'));
            $table->unsignedTinyInteger('nbr_people')->nullable()->comment('Nombre de personnes');
            $table->unsignedTinyInteger('nbr_beds')->nullable()->comment('Nombre de lits');
            $table->string('nbr_children_max')->nullable()->comment('Nombre maximun d\'enfants'); //energie
            $table->string('images')->nullable()->comment('Les images du produit'); //energie
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
        Schema::dropIfExists('products');
    }
}
