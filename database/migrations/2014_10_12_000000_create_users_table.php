<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\User;
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name')->comment(config('dbcomments.name'));
            $table->string('surname')->nullable()->comment(config('dbcomments.surname'));
            $table->string('email')->comment(config('dbcomments.email'));
            $table->string('password')->nullable();
            $table->date('birthday')->nullable()->comment(config('dbcomments.birthday'));
            $table->string('photo')->unique()->nullable()->comment(config('dbcomments.photo'));
            $table->string('birth_place')->nullable()->comment(config('dbcomments.birth_place'));
            $table->text('address')->nullable()->comment(config('dbcomments.address'));
            $table->string('tel')->nullable()->comment(config('dbcomments.tel'));
            $table->string('town')->nullable()->comment(config('dbcomments.town'));
            $table->string('country')->nullable()->comment(config('dbcomments.country'));
            $table->string('verified')->default(User::UNVERIFIED_USER);
            $table->string('admin')->default(User::REGULAR_USER);
            $table->string('verification_token')->nullable();
            $table->string('iban_nbr')->nullable()->comment(config('dbcomments.iban_nbr'));
            $table->string('nbr_rental')->default(0)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
