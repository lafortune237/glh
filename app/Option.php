<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';

    const DEFAULT_OPTIONS = array(
        'Bar',
        'Buanderie',
        'Animaux de compagnie acceptés',
        'Climatisation',
        'Crêche',
        'Déjeuner compris',
        'Piscine',
        'Spa',
        'Gym',
        'Service aux champbres',
        'Navette Aéroportuaire',
        'Terrain de tenis',
        'Terrain de  bascket',
        'Terrain de  foot',

    );
    protected $fillable = [
        'name'
    ];


}
