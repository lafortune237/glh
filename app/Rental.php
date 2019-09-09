<?php

namespace App;

use Carbon\Carbon;

class Rental extends Reservation
{
    const ONGOING_RENTAL = 'ongoing';
    const UPCOMING_RENTAL = 'upcoming';
    const CLOSED_RENTAL = 'closed';

    const CANCELED_BY_OWNER_RENTAL = 'AN-O';
    const CANCELED_BY_TENANT_RENTAL = 'AN-T';
    const CANCELED_BY_DRIVER_RENTAL = 'AN-D';
    const NORMAL_RENTAL = 'N';

    protected $appends = [
        'total',
        'timing_car',
        'timing_driver'
    ];


    public function getTimingCarAttribute()
    {
        if($this->hasCar()){

            /*$cars = $this->getCar();

            if($car->pivot->status == Rental::NORMAL_RENTAL){

               return $this->getTiming(Product::SUBJECT_CAR);

            }*/
        }

        return null;
    }

    public function getTimingDriverAttribute()
    {
        if($this->hasDriver()){

           /* $driver = $this->getDriver();

            if($driver->pivot->status == Rental::NORMAL_RENTAL){

                return $this->getTiming(Product::SUBJECT_DRIVER);

            }*/
        }

        return null;
    }

    public function getTiming($subject)
    {
        $timing = null;

        if($this->select->request_date_start && $this->request_date_end){

            $start_date = Carbon::createFromFormat('Y-m-d H:i:s',$this->request_date_start);
            $end_date = Carbon::createFromFormat('Y-m-d H:i:s',$this->request_date_end);

            if($start_date->lessThanOrEqualTo($end_date)){

                if($start_date->lessThanOrEqualTo(Carbon::now()) && $end_date->greaterThan(Carbon::now())){

                    $contrat = $this->contract()->where(['subject'=>$subject,'type'=>Contract::CONTRACT_START])->first();

                    $timing = $contrat ? Rental::ONGOING_RENTAL : Rental::UPCOMING_RENTAL;

                }elseif($start_date->greaterThan(Carbon::now())){

                    $timing = Rental::UPCOMING_RENTAL;

                }elseif ($end_date->lessThan(Carbon::now())){

                    $timing = Rental::CLOSED_RENTAL;
                }
            }
        }

        return $timing;
    }


    public function getTotalAttribute(){

        return null;
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

}
