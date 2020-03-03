<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Guides extends Model
{
    public $products = array();
    public function setAttributes($value)
    {
       
    }
    
}
