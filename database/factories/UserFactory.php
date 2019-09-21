<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Hostel;
use Illuminate\Support\Carbon;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {

    $user = [
        'name' => $name = $faker->firstName,
        'surname'=> $surname = $faker->lastName,
        'email' => $faker->unique()->email,
        'password' => bcrypt('secret'),
        'birthday'=>$faker->date('Y-m-d','now'),
        'photo'=>$faker->imageUrl( 640,   480), // 'http://lorempixel.com/640/480/'
        'birth_place'=>$faker->city,
        'address'=>$faker->address,
        'tel'=>$faker->phoneNumber,
        'town'=>$faker->city,
        'country'=>$faker->country,
        'verified'=> $verified = $faker->randomElement([User::VERIFIED_USER,User::UNVERIFIED_USER]),
        'verification_token'=> $verified == User::VERIFIED_USER ? null : User::generateVerificationCode(),
        'iban_nbr'=>$faker->iban('FR'),
    ];


    return $user;
});

$factory->define(Hostel::class, function (Faker $faker) {

    $hostel = [
        'user_id' => User::all()->random()->id,
        'name' => 'hotel '.$faker->name,
        'description'=>$faker->paragraph(10),
        'address_station'=>$faker->city,
        'address_latitude'=>$faker->latitude,
        'address_longitude'=>$faker->longitude,
        'contact'=>$faker->phoneNumber,
        'verified' => $faker->randomElement([Hostel::VERIFIED_HOSTEL,Hostel::UNVERIFIED_HOSTEL]),
        'email'=>$faker->email,
        'tel1'=>$faker->phoneNumber,
        'tel2'=>$faker->phoneNumber
    ];

    return $hostel;

});

$factory->define(\App\Selection::class, function (Faker $faker) {

    $user = User::all()->random();

    $date = Carbon::createFromFormat('Y-m-d H:i:s',$faker->dateTimeBetween('now','+30 days')->format('Y-m-d H:i:s'));

    $date_start = $date->format('Y-m-d H:i:s');

    $date_end = $date->addHours(rand(1,730))->format('Y-m-d H:i:s');

    $date_start_carbon = Carbon::createFromFormat('Y-m-d H:i:s',$date_start);

    $date_end_carbon = Carbon::createFromFormat('Y-m-d H:i:s',$date_end);

    $nbr_hours = null;
    $nbr_nights = null;

    if($date_start_carbon->diffInHours($date_end_carbon) < \App\Selection::MIN_HOURS){

       $nbr_hours = \App\Selection::MIN_HOURS;
    }

    if($date_start_carbon->diffInHours($date_end_carbon) < 24){

        $nbr_hours = $date_start_carbon->diffInHours($date_end_carbon);
    }

    if($date_start_carbon->diffInHours($date_end_carbon) >= 24){

        $nbr_nights = $date_start_carbon->diffInDays($date_end_carbon);
    }

    return [
        'user_id'=>$user->id,
        'address_station'=>$faker->city,
        'address_latitude'=>$faker->latitude,
        'address_longitude'=>$faker->longitude,
        'request_date_start'=> $date_start,
        'request_date_end'=> $date_end,
        'nbr_hours'=> $nbr_hours,
        'nbr_nights' => $nbr_nights,
    ];
});








