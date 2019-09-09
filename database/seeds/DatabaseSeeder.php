<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Admin;
use App\Brand;
use App\Category;
use App\Feature;
use App\Product;
use App\Reservation;
use App\Settings;
use App\Request;
use App\Rental;
use App\Contract;
use App\Type;
use App\Payment;
use App\Message;
use App\Forward;

use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Brand::truncate();
        Category::truncate();
        Feature::truncate();
        Type::truncate();
        Settings::truncate();
        User::truncate();
        Admin::truncate();
        Product::truncate();
        DB::table('feature_product')->truncate();
        Reservation::truncate();
        DB::table('product_selection')->truncate();
        Payment::truncate();
        Message::truncate();
        Contract::truncate();
        Forward::truncate();


        Brand::flushEventListeners();
        Category::flushEventListeners();
        Feature::flushEventListeners();
        Type::flushEventListeners();
        Settings::flushEventListeners();
        User::flushEventListeners();
        Admin::flushEventListeners();
        Product::flushEventListeners();
        Reservation::flushEventListeners();
        Payment::flushEventListeners();
        Message::flushEventListeners();
        Contract::flushEventListeners();
        Forward::flushEventListeners();

        $brands = Brand::DEFAULT_BRANDS;
        $categories = Category::DEFAULT_CATEGORIES;
        $features = Feature::DEFAULT_FEATURES;

        $usersQuantity = 100;
        $adminQuantity = 10;
        $productsQuantity = 1000;
        $selectionsQuantity = 1000;

        foreach ($brands as $key => $brand){
            DB::table('brands')->insert(array(
                'id' => $key+1,
                'name'=>$brand['title']
            ));
        };

        print "Table Brands migrated successfully'\n'";

        foreach ($categories as $key => $category){
            DB::table('categories')->insert(array(
                'id' => $key+1,
                'name'=>$category
            ));
        };

        print "Table Categories migrated successfully'\n'";

        DB::table('features')->insert($features);

        print "Table Features migrated successfully'\n'";

        foreach ($brands as $key => $model){
            foreach ($model['models'] as $key1 => $item){

                $category = Category::all()->random();

                DB::table('types')->insert(array(
                    'brand_id'=>$key+1,
                    'category_id'=>$category->id,
                    'model'=>$item['value']
                ));
            };
        };

        print "Table Brands migrated successfully'\n'";

        foreach (Settings::PRICES_CRITERIA as $key => $criterion){

            $rateTable = \Setting::get(Settings::PRODUCTS_RATES) ?? [];

            $rateTable[$key] = $criterion['val'];

            \Setting::set(Settings::PRODUCTS_RATES, $rateTable);

        };

        print "Table Settings migrated successfully'\n'";

        factory(User::class,$usersQuantity)->create()->each(

            function ($user){
                $faker = Faker\Factory::create('fr_FR');

                $product_id = DB::table('products')->insertGetId(array(
                    'user_id' => $user->id,
                    'type_id'=>Type::all()->random()->id,
                    'price_day'=>$faker->randomFloat(0,30,100),
                    'subject'=>Product::SUBJECT_DRIVER,
                    'description'=>$faker->paragraph(4),
                    'address_station'=>$faker->city,
                    'address_latitude'=>$faker->latitude,
                    'address_longitude'=>$faker->longitude,
                    'contact'=>$faker->phoneNumber,
                    'verified' => $faker->randomElement([Product::VERIFIED_PRODUCT,Product::UNVERIFIED_PRODUCT]),
                    'available'=> $faker->randomElement([Product::AVAILABLE_PRODUCT,Product::UNVERIFIED_PRODUCT]),
                    'direct_location' => Product::DIRECT_LOCATION,
                    'step'=>Product::NBR_DRIVER_STEPS,
                    'created_at'=> $created_at = date("Y-m-d H:i:s"),
                    'updated_at'=>$created_at
                ));

                foreach (Product::DEFAULT_DISCOUNTS as  $key => $rate){

                    $rateTable = \Setting::get($product_id) ?? [];

                    $rateTable[$key] = $rate;

                    \Setting::set($product_id, $rateTable);

                };
            });

        print "Table Users migrated successfully'\n'";

        factory(Admin::class,$adminQuantity)->create();

        print "Table Admins migrated successfully'\n'";

        factory(Product::class,$productsQuantity)->create()->each(
            function ($product){

                $features = Feature::all()->random(mt_rand(1,5))->pluck('id');

                $product->features()->attach($features);

                foreach (Product::DEFAULT_DISCOUNTS as  $key => $rate){

                    $rateTable = \Setting::get($product->id) ?? [];

                    $rateTable[$key] = $rate;

                    \Setting::set($product->id, $rateTable);

                };

            });

        print "Table Products migrated successfully'\n'";

        factory(Reservation::class,$selectionsQuantity)->create()->each(
            function ($selection){
                $faker = Faker\Factory::create('fr_FR');
                $tenant_products = $selection->user->products->pluck('id')->toArray();

                $tenant = $selection->user;

                $products =  Product::all()->except($tenant_products)->random(mt_rand(1,5));
                $total_rental = 0.00;

                $owners = [];
                $drivers = [];
                $i = 0;

                foreach ($products as $product){

                    if($product->direct_location == $selection->direct_location){
                        $status = $status = $faker->randomElement([Reservation::REQUEST_SELECTION,Reservation::RENTAL_SELECTION]);

                        $car = $selection->products()->where(['subject'=>Product::SUBJECT_CAR])->wherePivot('status','=','rental')->first();

                        $driver = $selection->products()->where(['subject'=>Product::SUBJECT_DRIVER])->wherePivot('status','=','rental')->first();

                        if($status == Reservation::REQUEST_SELECTION ||($status == Reservation::RENTAL_SELECTION && ($product->subject == Product::SUBJECT_CAR && !$car) || ($product->subject == Product::SUBJECT_DRIVER && !$driver))){

                            $info_price = $selection->getInfoPrice($product);

                            $can_cancel = $product->subject == Product::SUBJECT_CAR  ? Rental::CANCELED_BY_OWNER_RENTAL : Rental::CANCELED_BY_DRIVER_RENTAL;

                            $selection->products()->attach(
                                $product->id, [
                                'total'=> $total = $info_price['pricing'] ? $info_price['pricing']['total'] : 0.00,
                                'gain'=>$info_price['pricing'] ? $info_price['pricing']['gain'] : 0.00,
                                'pricing'=> $info_price['pricing'] ? json_encode($info_price['pricing']) : null,
                                'status'=> $status,
                                'state'=> $status ==
                                Reservation::REQUEST_SELECTION
                                    ?
                                    $faker->randomElement([
                                        Request::NOT_ACCEPTED_REQUEST,
                                        Request::ACCEPTED_REQUEST,
                                        Request::CANCELED_REQUEST,
                                        Request::EXPIRED_REQUEST,
                                        Request::DECLINED_AUTO_NOT_AVAILABLE_REQUEST,
                                        Request::DECLINED_AUTO_NOT_PAID_REQUEST,
                                        Request::DECLINED_REQUEST
                                    ])
                                    :
                                    $faker->randomElement([
                                        Rental::NORMAL_RENTAL,
                                        $can_cancel,
                                        Rental::CANCELED_BY_TENANT_RENTAL
                                    ]),
                                'created_at'=> $created_at = date("Y-m-d H:i:s"),
                                'updated_at'=>$created_at

                            ]);


                            $owner = $product->user;

                            if($product->subject == Product::SUBJECT_CAR){

                                $owners[$i] = [

                                    'id'=>$owner->id,
                                    'role'=> 'owner'
                                ];

                                $i++;
                            }

                            if($product->subject == Product::SUBJECT_DRIVER){

                                $drivers[$i] = [

                                    'id'=>$owner->id,
                                    'role'=> 'driver'
                                ];
                                $i++;
                            }

                            if($status == Reservation::RENTAL_SELECTION){

                                $signs_images = [

                                    '2d9d76fae57f02ec86572592e2f1ee52.png',
                                    '3edc345057a60dde5370211c1260bed2.png',
                                    '4bf59f5e62b30fdfe2ac04258e626e94.png',
                                    '2401085acf900a23a986956c0d56287d.png',
                                    'ac90e0f0237fbbb84ff0f0ab50ea8cf7.png',
                                    'e27b42027012afcc3a97e648a59426dc.png'
                                ];

                                $tenant->increment('nbr_rental');
                                $owner->increment('nbr_rental');
                                $product->increment('nbr_rental');

                                $total_rental += $total;

                                DB::table('contracts')->insert([
                                    'selection_id'=>$selection->id,
                                    'subject'=>$product->subject,
                                    'type'=>Contract::CONTRACT_START,
                                    'tenant_name'=> $selection->user->fullname,
                                    'tenant_birthday'=>$selection->user->birthday,
                                    'tenant_birth_place'=>$selection->user->birth_place,
                                    'tenant_address'=>$selection->user->address,
                                    'tenant_license'=>$selection->user->license,
                                    'tenant_license_image_front'=>$faker->imageUrl( 640,   480),
                                    'tenant_license_image_back'=>$faker->imageUrl( 640,   480),
                                    'second_driver'=> $second_driver = $product->subject == Product::SUBJECT_CAR && $driver ? Reservation::SECOND_DRIVER_YES : Reservation::SECOND_DRIVER_NO,
                                    'driver_name'=> $product->subject == Product::SUBJECT_DRIVER ? $product->user->fullname: null,
                                    'driver_birthday'=> $product->subject == Product::SUBJECT_DRIVER ? $product->user->birthday: null,
                                    'driver_birth_place'=> $product->subject == Product::SUBJECT_DRIVER ? $product->user->birth_place: null,
                                    'driver_address'=> $product->subject == Product::SUBJECT_DRIVER ? $product->user->address: null,
                                    'driver_license_image_front'=> $product->subject == Product::SUBJECT_DRIVER ? $faker->imageUrl( 640,   480): null,
                                    'driver_license_image_back'=> $product->subject == Product::SUBJECT_DRIVER ? $faker->imageUrl( 640,   480): null,
                                    'fuel_level'=>$product->subject == Product::SUBJECT_CAR  ? rand(1,9).'/'.rand(1,9) : null,
                                    'mileage_level'=>$product->subject == Product::SUBJECT_CAR  ? rand(200,1000) : null,
                                    'kilometers_included'=>$product->subject == Product::SUBJECT_CAR  ? $selection->kilometers_included : null,
                                    'front_image'=>$product->subject == Product::SUBJECT_CAR ? $faker->imageUrl( 640,   480): null,
                                    'backside_image'=>$product->subject == Product::SUBJECT_CAR ? $faker->imageUrl( 640,   480): null,
                                    'inner_image'=>$product->subject == Product::SUBJECT_CAR ? $faker->imageUrl( 640,   480): null,
                                    'right_side_image'=>$product->subject == Product::SUBJECT_CAR ? $faker->imageUrl( 640,   480): null,
                                    'left_side_image'=>$product->subject == Product::SUBJECT_CAR ? $faker->imageUrl( 640,   480): null,
                                    'surplus_image'=>$product->subject == Product::SUBJECT_CAR ? $faker->imageUrl( 640,   480): null,
                                    'signature_tenant'=>$faker->randomElement($signs_images),
                                    'signature_driver'=>$product->subject == Product::SUBJECT_DRIVER ? $faker->randomElement($signs_images) : null,
                                    'signature_owner'=>$product->subject == Product::SUBJECT_CAR ? $faker->randomElement($signs_images) : null,
                                    'created_at'=> $created_at = date("Y-m-d H:i:s"),
                                    'updated_at'=>$created_at
                                ]);

                                DB::table('contracts')->insert([
                                    'selection_id'=>$selection->id,
                                    'subject'=>$product->subject,
                                    'type'=>Contract::CONTRACT_END,
                                    'car_damaged'=> $car_damaged = $product->subject == Product::SUBJECT_CAR ? $faker->randomElement([Contract::CAR_DAMAGED,Contract::CAR_NOT_DAMAGED]): null,
                                    'outer_state'=> $product->subject == Product::SUBJECT_CAR && $car_damaged == Contract::CAR_DAMAGED ? $faker->paragraph(3): null,
                                    'inner_state'=> $product->subject == Product::SUBJECT_CAR && $car_damaged == Contract::CAR_DAMAGED ? $faker->paragraph(3): null,
                                    'distance_traveled'=>$product->subject == Product::SUBJECT_CAR ? rand(200,2000) : null,
                                    'signature_tenant'=>$faker->randomElement($signs_images),
                                    'signature_driver'=>$product->subject == Product::SUBJECT_DRIVER ? $faker->randomElement($signs_images) : null,
                                    'signature_owner'=>$product->subject == Product::SUBJECT_CAR ? $faker->randomElement($signs_images) : null,
                                    'date_end_tenant'=>date("Y-m-d H:i:s"),
                                    'date_end_owner'=> $product->subject == Product::SUBJECT_CAR ? date("Y-m-d H:i:s") : null,
                                    'date_end_driver'=> $product->subject == Product::SUBJECT_DRIVER ? date("Y-m-d H:i:s") : null,
                                    'created_at'=> $created_at = date("Y-m-d H:i:s"),
                                    'updated_at'=>$created_at
                                ]);

                            }

                        }

                    }
                }

                $users = array_merge($owners,$drivers);

                if(count($users) > 0){

                    $users[$i] = [
                        'id'=>$tenant->id,
                        'role'=>'tenant'
                    ];

                    for($j = 0; $j <=2; $j++){

                        $user = $faker->randomElement($users);
                        $subject = Product::SUBJECT_CAR;

                        if($user['role'] == 'tenant'){

                            if(count($owners) > 0 && count($drivers) > 0){

                                $subject = $faker->randomElement([Product::SUBJECT_DRIVER,Product::SUBJECT_CAR]);

                            }elseif(count($drivers) > 0){

                                $subject = Product::SUBJECT_DRIVER;
                            }
                        }
                        DB::table('messages')->insert([
                            'selection_id'=>$selection->id,
                            'user_id'=>$user['id'],
                            'user_role'=>$user['role'],
                            'subject'=>$subject,
                            'message'=>$faker->sentence(20),
                            'created_at'=> $created_at = date("Y-m-d H:i:s"),
                            'updated_at'=>$created_at
                        ]);
                    }

                    if($total_rental > 0.00){

                        DB::table('payments')->insert([
                            'selection_id'=>$selection->id,
                            'account_owner'=>$tenant->fullname,
                            'account_nbr'=>$faker->bankAccountNumber,
                            'expiration_date'=>$faker->date('Y-m-d','+20 years'),
                            'security_code'=>rand(100,999),
                            'total'=>$total_rental,
                            'created_at'=> $created_at = date("Y-m-d H:i:s"),
                            'updated_at'=>$created_at

                        ]);
                    }
                }

            });


        $products = Product::orderBy('nbr_rental','desc')->take(10)->get();

        foreach ($products as $product){
            DB::table('forwards')->insert([
                'product_id'=>$product->id,
                'created_at'=> $created_at = date("Y-m-d H:i:s"),
                'updated_at'=>$created_at
            ]);

        };

    }
}
