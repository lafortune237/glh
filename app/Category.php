<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    const DEFAULT_CATEGORIES = array(
        'Chambre Standard',
        'Chambre de Luxe',
        'Suite simple',
        'Suite couple',
        'Suite junior',

    );
    protected $fillable = [
        'name'
    ];

}
