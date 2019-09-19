<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    public $timestamps = true;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';

    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'birthday',
        'photo',
        'birth_place',
        'address',
        'tel',
        'town',
        'country',
        'verified',
        'admin',
        'verification_token',
        'iban_nbr',
        'nbr_rental',
        'email_verified_at',
    ];

    protected $appends = [
        'full_name',
        'full_name_abr'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    public function isAdmin()
    {
        return $this->admin == User::ADMIN_USER;
    }

    public function getFullNameAttribute()
    {
        return $this->surname.' '.$this->name;
    }

    public function getFullNameAbrAttribute()
    {
        return $this->surname.' '.substr($this->name,0,1).'.';
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function getSurnameAttribute($surname)
    {
        return ucfirst($surname);
    }

    public function getPhotoAttribute($photo)
    {
        if($photo == '' || $photo == ' ' || $photo == null){
            return url(config('images.userAvatar'));
        }
        if(strpos($photo,'facebook') == true || strpos($photo,'google') == true || strpos($photo,'lorempixel') == true){
            return $photo;

        }

        return url("uploads/{$photo}");

        //return url(config('images.userAvatar'));
    }


    public function setNameAttribute($surname)
    {
        $this->attributes['surname'] = strtolower($surname);
    }

    public function setSurnameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    public function isVerified()
    {
        return $this->verified == User::VERIFIED_USER;
    }

    /**
     * @return string
     */
    public static function generateVerificationCode()
    {
        return Str::random(40);
    }

    public function hostels()
    {
        return $this->hasMany(Hostel::class);
    }

    public function selections()
    {
        return $this->hasMany(Selection::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }



}
