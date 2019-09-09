<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'surname',
        'address',
        'email',
        'tel',
        'password',
        'role',
    ];


}
