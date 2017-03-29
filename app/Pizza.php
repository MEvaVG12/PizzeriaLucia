<?php

namespace App;

class Pizza extends Product {

    protected $fillable = ['name', 'precio'];

    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient');
    }
}
