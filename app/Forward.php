<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forward extends Model
{
    protected $table = 'forwards';
    public $timestamps = true;

    protected $fillable = [
      'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
