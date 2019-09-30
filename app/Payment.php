<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    public $timestamps = true;

    protected $fillable = [
        'selection_id',
        'account_owner',
        'account_nbr',
        'total',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class,'selection_id','id');
    }
}
