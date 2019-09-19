<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    const VERIFIED_HOSTEL = '1';
    const UNVERIFIED_HOSTEL = '0';

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
        'nbr_rental',
    ];

    protected $appends = [
        'front_image',
        'min_price'
    ];

    public function getMinPriceAttribute()
    {
        return $this->rooms()->min('price_night');
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

    public function images()
    {
        return $this->hasMany(HostelImage::class,'rel_id','id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
