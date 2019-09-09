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

    const DRIVER_LICENSES = array(
        'B',
        'B1',
        'B',
        'BE',
        'C1',
        'C1E',
        'C',
        'CE',
        'D1',
        'D1E',
        'D',
        'DE'
    );

    const IDENTITY_TYPES = [
        "Carte d'identité",
        "Carte de résidence",
        "Passport"
    ];

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
        'postal_code',
        'tel',
        'town',
        'country',
        'about',
        'verified',
        'verification_token',

        'license',
        'license_type',
        'license_image',
        'license_date_start',
        'license_date_end',
        'license_place',
        'licence_experience_date',
        'identity_type',
        'identity_nbr',
        'identity_place',
        'twitter',
        'linkedin',
        'youtube',
        'payment_account_owner',
        'iban_nbr',
        'nbr_rental',
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

    public function linkedSocialAccounts()
    {
        return $this->hasMany(LinkedSocialAccount::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function driver()
    {
        return $this->hasOne(Hostel::class);
    }

    public function cars()
    {
        return $this->hasMany(Room::class);
    }



}
