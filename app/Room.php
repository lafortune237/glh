<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    const AVAILABLE_ROOM = '1';
    const UNAVAILABLE_ROOM = '0';

    protected $table = 'rooms';
    public $timestamps = true;

    protected $fillable = [
        'hostel_id',
        'name',
        'category_id',
        'price_hour',
        'price_night',
        'description',
        'available',
        'nbr_rental',
        'nbr_beds',
        'nbr_people',

    ];

    protected $appends = [
        'price_hour_estimated',
        'price_night_estimated',
        'front_image'
    ];

    public function getNameAttribute($name)
    {
        if($name === null || $name == '' || $name == ' ' || !$name){

            return $this->category->name;
        }

        return $name.' ('.$this->category->name.')';
    }

    public function isAvailable()
    {
        return $this->available == Room::AVAILABLE_ROOM;
    }


    public function getFrontImageAttribute()
    {
        $front_image = $this->images()->where(['image_type'=>'front_image'])->first();


        if(!$front_image){
            return url(config('images.roomAvatar'));

        }

        return $front_image->filename;
    }

    public function getPriceHourEstimatedAttribute()
    {
        $taxes = $this->price_hour * (Reservation::PRICING_RATE / 100);
        return ceil($this->price_hour + $taxes);
    }

    public function getPriceNightEstimatedAttribute()
    {
        $taxes = $this->price_night * (Reservation::PRICING_RATE / 100);
        return ceil($this->price_night + $taxes);
    }

    public function getInfoPricing($start_date,$end_date)
    {
        return Selection::calculatePrice($this,$start_date,$end_date);
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function selections()
    {
        return $this->belongsToMany(Selection::class,'room_selection');
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class,'room_selection');
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class,'rel_id','id');
    }

    public function options()
    {
        return $this->belongsToMany(Option::class,'option_room');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
