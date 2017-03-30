<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = "Stocks";
    protected $fillable = ['amount','ingredient_id'];

    public function ingredient()
    {
      return $this->belongsTo('App\Ingredient');
    }
}
