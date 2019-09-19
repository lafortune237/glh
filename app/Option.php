<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';

    const DEFAULT_OPTIONS = [

        0 => [

            'id' => 1,
            'icon' => '',
            'option' => 'Bar',
            'name' => 'drink',
            'rel'=>'hostel'
        ],

        1 => [

            'id' => 2,
            'icon' => '',
            'option' => 'Buanderie',
            'name' => '',
            'rel'=>'hostel'
        ],

        2 => [

            'id' => 3,
            'icon' => '',
            'option' => 'Animaux de compagnie acceptés',
            'name' => '',
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
            'icon' => '',
            'option' => 'Crêche',
            'name' => '',
            'rel'=>'hostel'
        ],

        5 => [

            'id' => 6,
            'icon' => '',
            'option' => 'Déjeuner compris',
            'name' => '',
            'rel'=>'room'
        ],

        6 => [

            'id' => 7,
            'icon' => '',
            'option' => 'Piscine',
            'name' => 'swimming_pool',
            'rel'=>'hostel'
        ],

        7 => [

            'id' => 8,
            'icon' => '',
            'option' => 'Spa',
            'name' => 'spa',
            'rel'=>'hostel'
        ],
        8 => [

            'id' => 9,
            'icon' => '',
            'option' => 'Gym',
            'name' => 'gym',
            'rel'=>'hostel'
        ],

        9 => [

            'id' => 10,
            'icon' => '',
            'option' => 'Service aux champbres',
            'name' => '',
            'rel'=>'room'
        ],

        10 => [

            'id' => 11,
            'icon' => '',
            'option' => 'Navette Aéroportuaire',
            'name' => '',
            'rel'=>'hostel'
        ],

        11 => [

            'id' => 12,
            'icon' => '',
            'option' => 'Terrain de tenis',
            'name' => '',
            'rel'=>'hostel'
        ],

        12 => [

            'id' => 13,
            'icon' => '',
            'option' => 'Terrain de bascket',
            'name' => '',
            'rel'=>'hostel'
        ],

        13 => [

            'id' => 14,
            'icon' => '',
            'option' => 'Terrain de foot',
            'name' => '',
            'rel'=>'hostel'
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
