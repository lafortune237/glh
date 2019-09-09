<?php

namespace App;

class Hostel extends Product
{


    public function attributes()
    {
        return $this->user()->atributes;
    }

}
