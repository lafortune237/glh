<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Admin;
use App\Type;
use App\Product;
use App\Reservation;
use App\Room;
use Illuminate\Support\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
        'postal_code'=>$faker->postcode,
        'tel'=>$faker->phoneNumber,
        'town'=>$faker->city,
        'country'=>$faker->country,
        'about'=>$faker->paragraph(2),
        'verified'=> $verified = $faker->randomElement([User::VERIFIED_USER,User::UNVERIFIED_USER]),
        'verification_token'=> $verified == User::VERIFIED_USER ? null : User::generateVerificationCode(),
        'license'=>strtoupper($faker->text(12)),
        'license_type'=>$faker->randomElement(User::DRIVER_LICENSES),
        'license_image'=>$faker->imageUrl( 640,   480),
        'license_date_start'=>$faker->date('Y-m-d','now'),
        'license_date_end'=>$faker->date('Y-m-d','+49 years'),
        'license_place'=>$faker->city,
        'licence_experience_date'=>$faker->date('Y-m-d','now'),
        'identity_type'=>$faker->randomElement(User::IDENTITY_TYPES),
        'identity_nbr'=>strtoupper($faker->text(12)),
        'identity_place'=>$faker->city,
        'twitter'=>$faker->url,
        'linkedin'=>$faker->url,
        'youtube'=>$faker->url,
        'payment_account_owner'=>$surname.' '.$surname,
        'iban_nbr'=>$faker->iban('FR'),
    ];


    return $user;
});

$factory->define(Admin::class, function (Faker $faker) {

    return [
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'address' => $faker->address,
        'email' => $faker->unique()->email,
        'tel'=>$faker->phoneNumber,
        'password' => bcrypt('admin'),
        'role' =>null,
    ];

});

$factory->define(Product::class, function (Faker $faker) {

    $location_type = $faker->randomElement([Product::DIRECT_LOCATION,Product::INDIRECT_LOCATION]);
    $type = Type::all()->random();

    $mileages = [];

    for($i = 15000;$i<=90000;$i+=15000){
        $mileages[$i] = $i;

    }
    $mileage = $faker->randomElement($mileages);

    $consumptions = [];

    for($i = 0; $i<=20;$i++){

        $consumptions[$i] = $i;
    }

    $consumption = $faker->randomElement($consumptions);

    $car_images = [
        '1.jpeg','2.jpeg','3.jpeg','4.jpg','5.jpg','6.jpg','7.jpg','8.jpg','9.jpg','10.jpeg',
        '11.jpeg','12.jpeg','13.jpeg','14.jpeg','15.jpg','16.jpg','17.jpg','18.jpeg','19.jpg','20.jpeg',
        '21.jpeg','22.jpg','23.jpg','24.jpg','25.jpg','26.jpg','27.jpeg','28.jpeg','29.jpeg','30.jpeg',
        '31.jpeg','32.jpg','33.jpg','34.jpg','35.jpg','36.jpg','37.jpeg','38.jpeg','39.jpeg','40.jpeg',
        '41.jpeg','42.jpeg','43.jpeg','44.jpeg','45.jpeg','46.jpeg','47.jpeg','48.jpeg','49.jpeg','50.jpeg',
        '51.jpg','52.jpg','53.jpg','54.jpg','55.jpg','56.jpg','57.jpg','58.jpg','59.jpg','60.jpg',
        '61.jpg','62.jpg','63.jpg','64.jpg','65.jpg','66.jpg','67.jpeg'
    ];

    $car_front_images = [
        '3.jpeg','11.jpeg','14.jpeg','17.jpg','20.jpeg','21.jpeg','26.jpg','30.jpeg','45.jpeg','48.jpeg',
        '50.jpeg','54.jpg','56.jpg','57.jpg','58.jpg','60.jpg','61.jpg','62.jpg','63.jpg','65.jpg',
        '66.jpg','67.jpeg',
    ];

    $product = [
        'user_id' => User::all()->random()->id,
        'type_id'=> $type->id,
        'price_day'=>$faker->randomFloat(0,30,100),
        'subject'=>Product::SUBJECT_CAR,
        'description'=>$faker->paragraph(4),
        'address_station'=>$faker->city,
        'address_latitude'=>$faker->latitude,
        'address_longitude'=>$faker->longitude,
        'contact'=>$faker->phoneNumber,
        'verified' => $faker->randomElement([Product::VERIFIED_PRODUCT,Product::UNVERIFIED_PRODUCT]),
        'available'=> $faker->randomElement([Product::AVAILABLE_PRODUCT,Product::UNVERIFIED_PRODUCT]),
        'direct_location' => $location_type,
        'year'=>rand(1945,date('Y')),
        'category'=>$type->category->name,
        'nbr_seats'=>rand(2,9),
        'nbr_doors'=>rand(1,5),
        'energy'=>$faker->randomElement(Room::ENERGIES),
        'gearbox'=>$faker->randomElement(Room::GEARBOXES),
        'mileage'=>$mileage,
        'consumption'=>$consumption,
        'registration'=>Str::random(10),
        'certificate'=>Str::random(10),
        'registered_country'=>$faker->country,
        'start_date_validity_insurance'=>$faker->date('Y-m-d','now'),
        'end_date_validity_insurance'=>$faker->date('Y-m-d','+1 years'),
        'certificate_image'=>$faker->imageUrl( 640,   480),
        'front_image'=>$faker->randomElement($car_front_images),
        'backside_image'=>$faker->randomElement($car_images),
        'inner_image'=>$faker->randomElement($car_images),
        'right_side_image'=>$faker->randomElement($car_images),
        'left_side_image'=>$faker->randomElement($car_images),
        'surplus_image'=>$faker->randomElement($car_images),
        'step'=>Product::NBR_CAR_STEPS,
    ];

    return $product;

});

$factory->define(Reservation::class, function (Faker $faker) {

    $user = User::all()->random();

    $date = Carbon::createFromFormat('Y-m-d H:i:s',$faker->dateTimeBetween('now','+30 days')->format('Y-m-d H:i:s'));

    $date_start = $date->format('Y-m-d H:i:s');

    $date_end = $date->addHours(rand(1,730))->format('Y-m-d H:i:s');

    $date_start_carbon = Carbon::createFromFormat('Y-m-d H:i:s',$date_start);

    $date_end_carbon = Carbon::createFromFormat('Y-m-d H:i:s',$date_end);

    return [
        'user_id'=>$user->id,
        'address_station'=>$faker->city,
        'address_latitude'=>$faker->latitude,
        'address_longitude'=>$faker->longitude,
        'request_date_start'=> $date_start,
        'request_date_end'=> $date_end,
        'nbr_days'=> $nbr_days = $date_start_carbon->diffInHours($date_end_carbon) <= Reservation::MIN_HOURS ? null : $date_start_carbon->diffInDays($date_end_carbon),
        'nbr_hours' => $nbr_hours = $date_start_carbon->diffInHours($date_end_carbon) <= Reservation::MIN_HOURS ? Reservation::MIN_HOURS : null,
        'kilometers_included' => $nbr_days != null ? $nbr_days * Reservation::MILEAGE_PER_DAY : Reservation::MILEAGE_PER_DAY,
        'meeting_place'=>$faker->address,
        'direct_location'=>$faker->randomElement([Product::DIRECT_LOCATION,Product::INDIRECT_LOCATION])
    ];
});








