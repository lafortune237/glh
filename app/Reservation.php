<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';
    public $timestamps = true;

    const MIN_HOURS = 4;
    const MAX_DAYS = 30;
    const MILEAGE_PER_DAY = 200;

    const SECOND_DRIVER_YES = '1';
    const SECOND_DRIVER_NO = '0';

    const RENTAL_SELECTION = 'rental';
    const REQUEST_SELECTION = 'request';

    const FEE_SERVICES = 3;

    protected $fillable = [
        'user_id',
        'address_station',
        'address_latitude',
        'address_longitude',
        'request_date_start',
        'request_date_end',
        'nbr_days',
        'nbr_hours',

    ];

    protected $appends = [
        'subject',
    ];

    public function hasCar()
    {
        return $this->subject == Product::SUBJECT_CAR || $this->hasCarAndDriver();
    }

    public function hasDriver()
    {
        return $this->subject == Product::SUBJECT_DRIVER || $this->hasCarAndDriver();
    }

    public function hasCarAndDriver()
    {
        return $this->subject == Product::SUBJECT_CAR_DRIVER;
    }

    public function getCar($car)
    {
        return $this->products()->where(['id'=>$car->id,'subject'=>Product::SUBJECT_CAR])->get();
    }

    public function getDriver($driver)
    {
        return $this->products()->where(['id'=>$driver->id,'subject'=>Product::SUBJECT_DRIVER])->get();
    }

    public function getCars()
    {
        return $this->products()->where(['subject'=>Product::SUBJECT_CAR])->get();
    }

    public function getDrivers()
    {
        return $this->products()->where(['subject'=>Product::SUBJECT_DRIVER])->get();
    }

    public function getInfoPrice($product){

        $start_date = Carbon::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s',strtotime($this->request_date_start)));

        $end_date = Carbon::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s',strtotime($this->request_date_start)));

        $price_estimated = $product->price_estimated;

        $price_day = $product->price_day;

        $fee_service = Reservation::FEE_SERVICES;

        if ($start_date->lessThanOrEqualTo($end_date)) {

            if ($start_date->lessThan(Carbon::now())) {

                $param = [
                    'option' => 'calculated',
                    'message' => 'passed_date',
                    'element' => $product->subject,
                ];

            } elseif ($start_date->diffInHours($end_date) <= 4) {
                $nbr_hours = 4;
                $total_ht = $price_day;
                $total = $total_ht + $fee_service;
                $mileage = Reservation::MILEAGE_PER_DAY;

                $param = [
                    'option' => 'calculated',
                    'message' => 'success',
                    'nbr_hours' => $nbr_hours,
                    'element' => $product->subject,
                    'pricing' => [
                        'total' => $total,
                        'gain' => ceil($total_ht * (80 / 100)),
                        'mileage' => $mileage,
                        'nbr_hours' => $nbr_hours,
                        'base_pricing' => [
                            'price_day' => $price_day,
                            'price_estimated' => $price_estimated,

                        ],

                        'fees_pricing' => [
                            'fee_service' => $fee_service

                        ]

                    ],

                ];

            } elseif ($start_date->diffInDays($end_date) > 30) {

                $param = [
                    'option' => 'calculated',
                    'message' => 'delay_passed',
                    'element' => $product->subject,
                ];
            } else {

                $nbr_days = $start_date->diffInDays($end_date);
                $total_ht = $nbr_days * $price_day;
                $total = $total_ht + $fee_service;
                $mileage = $nbr_days * Reservation::MILEAGE_PER_DAY;

                $param = [
                    'option' => 'calculated',
                    'message' => 'success',
                    'mileage' => $mileage,
                    'nbr_days' => $nbr_days,
                    'element' => $product->subject,
                    'pricing' => [
                        'total' => $total,
                        'gain' => ceil($total_ht * (80 / 100)),
                        'mileage' => $mileage,
                        'nbr_days' => $nbr_days,
                        'base_pricing' => [
                            'price_day' => $price_day,
                            'price_estimated' => $price_estimated,

                        ],

                        'fees_pricing' => [
                            'fee_service' => $fee_service

                        ]

                    ],
                ];
            }

        } else {

            $param = [
                'option' => 'calculated',
                'message' => 'invalid_dates',
                'element' => $product->subject,
            ];

        }

        return $param;
    }

    public function setTypeAttribute()
    {
        $type = null;
        $cars = $this->products()->where(['subject'=>Product::SUBJECT_CAR])->get();

        if($cars->count() > 0){

            if($cars[0]->isDirectLocation()){

                $type = Product::DIRECT_LOCATION;
            }else{

                $type = Product::INDIRECT_LOCATION;
            }
        }

        $this->attributes['type'] = $type;
    }

    public function setSubjectAttribute()
    {
        $subject = null;
        $cars = $this->products()->where(['subject'=>Product::SUBJECT_CAR])->count();
        $drivers = $this->products()->where(['subject'=>Product::SUBJECT_DRIVER])->count();

        if($cars > 0 && $drivers > 0){

            $subject = Product::SUBJECT_CAR_DRIVER;

        }else{

            if($drivers > 0){

                $subject = Product::SUBJECT_DRIVER;
            }elseif($cars > 0){

                $subject = Product::SUBJECT_CAR;
            }
        }

        $this->attributes['subject'] = $subject;
    }

    public function setKilometerIncludedAttribute()
    {
        if(!$this->nbr_days){

            $this->attributes['kilometer_included'] = Reservation::MILEAGE_PER_DAY;
        }

        $this->attributes['kilometer_included'] = $this->nbr_days * Reservation::MILEAGE_PER_DAY;
    }

    public function setNbrDaysAttribute()
    {
        $start_date = Carbon::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s',strtotime($this->request_date_start)));

        $end_date = Carbon::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s',strtotime($this->request_date_end)));

        if($start_date->diffInHours($end_date) <= Reservation::MIN_HOURS){

            $this->attributes['nbr_hours'] = Reservation::MIN_HOURS;
            $nbr_days = null;

        }else{
            $nbr_days = $start_date->diffInDays($end_date);
        }

        $this->attributes['nbr_days'] = $nbr_days;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }


}
