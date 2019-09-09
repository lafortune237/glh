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
        'expiration_date',
        'security_code',
        'total',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}
