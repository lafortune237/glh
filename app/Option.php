<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';

    const DEFAULT_OPTIONS = [

        0 => [

            'id' => 1,
            'icon' => 'fas fa-beer',
            'option' => 'Bar',
            'name' => 'bar',
            'rel'=>'hostel'
        ],

        1 => [

            'id' => 2,
            'icon' => 'fad fa-h-square',
            'option' => 'Buanderie',
            'name' => 'washer',
            'rel'=>'hostel'
        ],

        2 => [

            'id' => 3,
            'icon' => 'fas fa-dog',
            'option' => 'Animaux de compagnie acceptés',
            'name' => 'pet',
            'rel'=>'hostel'
        ],
        3 => [

            'id' => 4,
            'icon' => 'fa fa-snowflake-o',
            'option' => 'Climatisation',
            'name' => 'air_conditioner',
            'rel'=>'room'
        ],

        4 => [

            'id' => 5,
            'icon' => 'fas fa-baby',
            'option' => 'Crêche',
            'name' => 'sitter',
            'rel'=>'hostel'
        ],

        5 => [

            'id' => 6,
            'icon' => 'fas fa-utensils',
            'option' => 'Déjeuner compris',
            'name' => 'launch',
            'rel'=>'room'
        ],

        6 => [

            'id' => 7,
            'icon' => 'fas fa-swimming-pool',
            'option' => 'Piscine',
            'name' => 'swimming_pool',
            'rel'=>'hostel'
        ],

        7 => [

            'id' => 8,
            'icon' => 'fas fa-hot-tub',
            'option' => 'Spa',
            'name' => 'spa',
            'rel'=>'hostel'
        ],
        8 => [

            'id' => 9,
            'icon' => 'fas fa-dumbbell',
            'option' => 'Gym',
            'name' => 'gym',
            'rel'=>'hostel'
        ],

        9 => [

            'id' => 10,
            'icon' => 'fas fa-hands-helping',
            'option' => 'Service aux champbres',
            'name' => 'help',
            'rel'=>'room'
        ],

        10 => [

            'id' => 11,
            'icon' => 'fas fa-shuttle-van',
            'option' => 'Navette Aéroportuaire',
            'name' => 'shuttle',
            'rel'=>'hostel'
        ],

        11 => [

            'id' => 12,
            'icon' => 'fad fa-h-square',
            'option' => 'Terrain de tenis',
            'name' => 'tenis',
            'rel'=>'hostel'
        ],

        12 => [

            'id' => 13,
            'icon' => 'fas fa-basketball-ball',
            'option' => 'Terrain de bascket',
            'name' => 'basket',
            'rel'=>'hostel'
        ],

        13 => [

            'id' => 14,
            'icon' => 'fas fa-futbol',
            'option' => 'Terrain de foot',
            'name' => 'football',
            'rel'=>'hostel'
        ],
        14 => [

            'id' => 15,
            'icon' => 'fas fa-wifi',
            'option' => 'Wifi gratuit',
            'name' => 'wifi',
            'rel'=>'hostel'
        ],

        15 => [

            'id' => 16,
            'icon' => 'fas fa-wifi',
            'option' => 'Wifi gratuit',
            'name' => 'wifi',
            'rel'=>'room'
        ],
    ];

    protected $fillable = [
        'icon',
        'option',
        'name',
        'rel'
    ];


    public function rooms()
    {
        return $this->belongsToMany(Room::class,'option_room');
    }

    public function hostels()
    {
        return $this->belongsToMany(Hostel::class,'option_hostel');
    }



}
