<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    const VERIFIED_HOSTEL = '1';
    const UNVERIFIED_HOSTEL = '0';

    const FORWARDED_HOSTEL = '1';
    const REGULAR_HOSTEL = '0';

    protected $table = 'hostels';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'address_station',
        'address_latitude',
        'address_longitude',
        'contact',
        'email',
        'tel1',
        'tel2',
        'verified',
        'forwarded',
        'nbr_rental',
    ];

    protected $appends = [
        'front_image',
        'min_price'
    ];

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function getAddressStationAttribute($address)
    {
        return ucwords($address);
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    public function setAddressStationAttribute($address)
    {
        $this->attributes['address_station'] = strtolower($address);
    }

    public function checkOption($option_name)
    {
        foreach ($this->options as $option){

            if($option->name == $option_name){

                return 'checked';
            }
        }

        return '';
    }

    public function getMinPriceAttribute()
    {

        $min_price = $this->rooms()->where(['available'=>Room::AVAILABLE_ROOM])->min('price_night');

        $taxes = $min_price * (Reservation::PRICING_RATE / 100);
        return ceil($min_price + $taxes);

    }

    public function getFrontImageAttribute()
    {
        $front_image = $this->images()->where(['image_type'=>'front_image'])->first();

        if(!$front_image){
            return url(config('images.hostelAvatar'));

        }

        return $front_image->filename;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class,'option_hostel');
    }

    public function isVerified()
    {
        return $this->verified == Hostel::VERIFIED_HOSTEL;
    }

    public function isForwarded()
    {
        return $this->forwarded == Hostel::FORWARDED_HOSTEL;
    }

    public function images()
    {
        return $this->hasMany(HostelImage::class,'rel_id','id')->take(5);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function AvailableRooms()
    {
        return $this->hasMany(Room::class)->where(['available'=>Room::AVAILABLE_ROOM]);
    }
}
