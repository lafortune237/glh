<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Settings;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = true;

    const AVAILABLE_PRODUCT = '1';
    const UNAVAILABLE_PRODUCT = '0';

    const VERIFIED_PRODUCT = '1';
    const UNVERIFIED_PRODUCT = '0';

    const SUBJECT_ROOM = 'room';
    const SUBJECT_HOSTEL = 'hostel';
    const MAX_NBR_IMAGES = 20;

    const DEFAULT_DISCOUNTS = [
        '3_day' => 15,
        '7_day' => 35,
        '30_day' => 55,

    ];



    protected $fillable = [
        'user_id',
        'type_id',
        'price_night',
        'subject',
        'description',
        'address_station',
        'address_latitude',
        'address_longitude',
        'contact',
        'verified',
        'available',
        'direct_location',
        'nbr_rental',
        'nbr_people',
        'nbr_beds',
        'nbr_children_max',
        'images',



    ];

    protected $appends = [
        'full_name',
        'price_estimated'
    ];


    public function isAvailable()
    {
        return $this->available == Product::AVAILABLE_PRODUCT;
    }


    public function isVerified()
    {
        return $this->verified == Product::VERIFIED_PRODUCT;
    }

    public function getPriceEstimatedAttribute()
    {
        $rate = Settings::getPriceRates();

        $taxes = $this->price_night * $rate / 100;
        return ceil($this->price_night + $taxes);
    }

    public function getFullNameAttribute()
    {
        if($this->subject == Product::SUBJECT_HOSTEL){

            return $this->user->full_name;
        }

        return $this->type->full_model;
    }

    public function forward()
    {
        return $this->hasOne(Forward::class);
    }


    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function setting()
    {
        return $this->hasOne(Settings::class,'key','id');
    }

    public function type()
    {
        return $this->hasOne(Type::class,'id', 'type_id');
    }


}
