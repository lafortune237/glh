<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    const DEFAULT_CATEGORIES = [

        0 => [

            'id' => 1,
            'name' => 'Chambre Standard',
        ],

        1 => [

            'id' => 2,
            'name' => 'Chambre de Luxe',
        ],

        2 => [

            'id' => 3,
            'name' => 'Suite simple',
        ],
        3 => [

            'id' => 4,
            'name' => 'Suite couple',
        ],

        4 => [

            'id' => 5,
            'name' => 'Suite junior',
        ],
    ];

    protected $fillable = [
        'name'
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

}
