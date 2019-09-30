<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    protected $table = 'selections';
    public $timestamps = true;

    const MIN_HOURS = 2;
    const MAX_NIGHTS = 30;

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
        'nbr_hours',
        'nbr_night',

    ];

    protected $appends = [
        'date_start_human',
        'date_end_human',
        'timing',
        'total',
        'nbr_rooms'
    ];

    public function getTimingAttribute()
    {
        if($this->request_date_start && $this->request_date_end){
            $start_date = Carbon::createFromFormat('Y-m-d H:i:s',$this->request_date_start);

            $end_date = Carbon::createFromFormat('Y-m-d H:i:s',$this->request_date_end);

            if($start_date->lessThanOrEqualTo($end_date)){

                if($start_date->lessThanOrEqualTo(Carbon::now()) && $end_date->greaterThan(Carbon::now())){

                    return   Reservation::ONGOING_RENTAL ;

                }elseif($start_date->greaterThan(Carbon::now())){

                    return Reservation::UPCOMING_RENTAL;

                }elseif ($end_date->lessThan(Carbon::now())){

                    return Reservation::CLOSED_RENTAL;
                }
            }
        }
        return null;
    }

    public function getDateStartHumanAttribute()
    {
        $date= date('Y-m-d',strtotime($this->request_date_start));
        $time= date('H:i',strtotime($this->request_date_start));
        $year = date('Y',strtotime($this->request_date_start));

        if((date('Y') - $year > 1)){
            $date = Carbon::createFromFormat('Y-m-d',$date)->isoFormat('D MMM YYYY');
        }else{
            $date = Carbon::createFromFormat('Y-m-d',$date)->isoFormat('D MMM');
        }

        return ucfirst($date).' à '.$time;
    }

    public function getDateEndHumanAttribute()
    {
        $date= date('Y-m-d',strtotime($this->request_date_end));
        $time= date('H:i',strtotime($this->request_date_end));
        $year = date('Y',strtotime($this->request_date_end));

        if((date('Y') - $year > 1)){
            $date = Carbon::createFromFormat('Y-m-d',$date)->isoFormat('D MMM YYYY');
        }else{
            $date = Carbon::createFromFormat('Y-m-d',$date)->isoFormat('D MMM');
        }

        return ucfirst($date).' à '.$time;
    }

    public function getInfoPricing($room)
    {
        return $this->calculatePrice($room,$this->request_date_start,$this->request_date_end);
    }

    public static function calculatePrice($room,$start_date, $end_date)
    {
        $start_date = Carbon::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s',strtotime($start_date)));

        $end_date = Carbon::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s',strtotime($end_date)));

        $price_night = $room->price_night;
        $price_night_estimated = $room->price_night_estimated;

        $price_hour = $room->price_hour;
        $price_hour_estimated = $room->price_hour_estimated;

        if($start_date->greaterThan($end_date)) {

            return response()->json([
                'option' => 'calculated',
                'message' => 'invalid_dates'
            ], 200);
        }

        if($start_date->lessThan(Carbon::now())){

            return response()->json([
                'option' => 'calculated',
                'message' => 'passed_dates'
            ], 200);
        }

        if($start_date->diffInDays($end_date) > Selection::MAX_NIGHTS){

            return response()->json([
                'option' => 'calculated',
                'message' => 'delay_passed'
            ], 200);
        }

        if($start_date->diffInHours($end_date) < Selection::MIN_HOURS){

            return response()->json([
                'option' => 'calculated',
                'message' => 'short_date'
            ], 200);
        }

        if($start_date->diffInHours($end_date) < 24){

            $nbr_hours = $start_date->diffInHours($end_date);
            $total_ht = $nbr_hours * $price_hour;
            $total = $nbr_hours * $price_hour_estimated;

            return response()->json([
                'option' => 'calculated',
                'message' => 'success',
                'pricing'=>[
                    'total' => $total,
                    'total_ht'=>$total_ht,
                    'nbr_hours'=> $nbr_hours,
                    'base_pricing' => [
                        'price_hour' => $price_hour,
                        'price_hour_estimated'=>$price_hour_estimated
                    ],
                ]
            ], 200);
        }

        $nbr_nights = $start_date->diffInDays($end_date);
        $total_ht = $nbr_nights * $price_night;
        $total = $nbr_nights * $price_night_estimated;

        return response()->json([
            'option' => 'calculated',
            'message' => 'success',
            'pricing'=>[
                'total' => $total,
                'total_ht'=>$total_ht,
                'nbr_nights'=> $nbr_nights,
                'base_pricing' => [
                    'price_night' => $price_night,
                    'price_night_estimated'=>$price_night_estimated

                ],
            ]
        ], 200);

    }

    public function getTotalAttribute()
    {
        $total = 0.00;

        if(!$this->rooms->isEmpty()){

            foreach ($this->rooms as $room){

                if($room->isAvailable()){
                    $total += $room->pivot->total;
                }

            }
        }


        return $total;
    }

    public function getNbrRoomsAttribute()
    {
        $nbr = 0;

        if(!$this->rooms->isEmpty()){

            foreach ($this->rooms as $room){

                if($room->isAvailable()){
                    $nbr += 1;
                }

            }
        }

        return $nbr;
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class,'room_selection')
            ->withPivot(['status','total','pricing','created_at','updated_at']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class,'selection_id','id');
    }

}
