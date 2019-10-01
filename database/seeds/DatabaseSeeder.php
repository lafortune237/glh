<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Payment;
use App\Option;
use App\Hostel;
use App\Room;
use App\Image;
use App\Selection;

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
        Category::truncate();
        Option::truncate();
        User::truncate();
        Hostel::truncate();
        Room::truncate();
        DB::table('option_hostel')->truncate();
        DB::table('option_room')->truncate();
        Image::truncate();
        Selection::truncate();
        DB::table('room_selection')->truncate();
        Payment::truncate();


        Category::flushEventListeners();
        Option::flushEventListeners();
        User::flushEventListeners();
        Hostel::flushEventListeners();
        Room::flushEventListeners();
        Image::flushEventListeners();
        Selection::flushEventListeners();
        Payment::flushEventListeners();

        $categories = Category::DEFAULT_CATEGORIES;
        $options = Option::DEFAULT_OPTIONS;

        $usersQuantity = 20;
        $hostelsQuantity = 50;
        $selectionsQuantity = 100;

        DB::table('categories')->insert($categories);

        print "Table Categories migrated successfully'\n'";

        DB::table('options')->insert($options);

        print "Table Options migrated successfully'\n'";

        factory(User::class,$usersQuantity)->create();

        print "Table Users migrated successfully'\n'";

        factory(Hostel::class,$hostelsQuantity)->create()->each(
            function ($hostel){

                $hostel_options = Option::where('rel','=','hostel')->get()->random(mt_rand(1,5))->pluck('id');

                $faker = Faker\Factory::create('fr_FR');

                $hostel->options()->attach($hostel_options);
                $images = [];

                for($i= 1; $i<= 9;$i++){

                    $images[$i] = $i.'.jpg';
                }

               $hostel->forwarded = $hostel->isVerified() &&

               Hostel::where(['forwarded'=>Hostel::FORWARDED_HOSTEL])->get()->count() < 15 ?
                    Hostel::FORWARDED_HOSTEL : Hostel::REGULAR_HOSTEL;

                $hostel->save();

                for($i= 0; $i< 5;$i++){

                    DB::table('images')->insert([
                        'rel_id'=>$hostel->id,
                        'filename' => 'hostels/'.$faker->randomElement($images),
                        'image_type'=>$faker->randomElement(Image::DEFAULT_IMAGES_TYPES),
                        'rel'=>'hostel',
                        'created_at'=> $created_at = date("Y-m-d H:i:s"),
                        'updated_at'=>$created_at
                    ]);
                }

                $images = [];

                for($i= 1; $i<= 8;$i++){

                    $images[$i] = $i.'.jpg';
                }


                for($i = 0; $i<= mt_rand(1,4); $i++){
                    $room_options = Option::where('rel','=','room')->get()->random(mt_rand(1,3))->pluck('id');

                    $category = Category::all()->random();

                    $room_id = DB::table('rooms')->insertGetId([
                        'hostel_id'=>$hostel->id,
                        'name' => $category->name,
                        'category_id'=>$category->id,
                        'price_hour'=>$faker->randomElement([2000,2500,3000]),
                        'price_night'=>$faker->randomElement([10000,12000,15000,20000,25000,30000,35000,40000]),
                        'description'=>$faker->paragraph(6),
                        'available' => $faker->randomElement([Room::AVAILABLE_ROOM,Room::UNAVAILABLE_ROOM]),
                        'nbr_beds'=> $nbr_beds = mt_rand(1,3),
                        'nbr_people'=> ($nbr_beds * mt_rand(1,2)) + 1,
                        'created_at'=> $created_at = date("Y-m-d H:i:s"),
                        'updated_at'=>$created_at
                    ]);

                    $room = Room::find($room_id);

                    $room->options()->attach($room_options);

                    for($j = 0; $j< 5;$j++){

                        DB::table('images')->insert([
                            'rel_id'=>$room->id,
                            'filename' => 'rooms/'.$faker->randomElement($images),
                            'image_type'=>$faker->randomElement(Image::DEFAULT_IMAGES_TYPES),
                            'rel'=>'room',
                            'created_at'=> $created_at = date("Y-m-d H:i:s"),
                            'updated_at'=>$created_at
                        ]);
                    }
                }

            });

        print "Table Hostels migrated successfully'\n'";

        factory(Selection::class,$selectionsQuantity)->create()->each(
            function ($selection){

                $tenant_rooms = $selection->user()
                    ->with('hostels.rooms')
                    ->get()
                    ->pluck('hostels')
                    ->collapse()
                    ->pluck('rooms')
                    ->collapse()
                    ->pluck('id')
                    ->values()
                    ->toArray();

                $rooms = Room::all()->except($tenant_rooms)->random(mt_rand(1,3));
                $faker = Faker\Factory::create('fr_FR');

                $total_rental = 0.00;

                foreach ($rooms as $room){

                    $info_price = $selection->getInfoPricing($room)->getData();

                    if(isset($info_price->pricing)){

                        $total_rental += $info_price->pricing->total;

                        $selection->rooms()->attach($room->id, [
                            'total'=>$info_price->pricing->total,
                            'pricing'=>json_encode($info_price->pricing),
                            'created_at'=> $created_at = date("Y-m-d H:i:s"),
                            'updated_at'=>$created_at
                        ]);
                    }
                }

                if($total_rental > 0.00){

                    DB::table('payments')->insert([
                        'selection_id'=>$selection->id,
                        'account_owner' => $selection->user->full_name,
                        'account_nbr' => $faker->bankAccountNumber,
                        'total'=>$total_rental,
                        'created_at'=> $created_at = date("Y-m-d H:i:s"),
                        'updated_at'=>$created_at
                    ]);

                    $selection->user->increment('nbr_rental');

                    foreach ($rooms as $room){

                        $room->increment('nbr_rental');
                        $room->hostel->increment('nbr_rental');

                        $room->hostel->user->increment('nbr_rental');
                    }
                }

            });

        print "Table Selections migrated successfully'\n'";

    }
}
