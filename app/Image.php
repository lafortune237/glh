<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    const DEFAULT_IMAGES_TYPES = [
      'front_image',
      'inner_image',
      'backside_image',
      'left_side_image',
      'right_side_image',
      'surplus_image'
    ];

    protected $fillable = [
        'rel_id',
        'filename',
        'image_type',
        'rel'
    ];


    public function getFilenameAttribute($image)
    {
        return url("img/{$image}");
    }

}
