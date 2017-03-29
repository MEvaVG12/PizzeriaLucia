<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $table = "products";
  protected $fillable = ['name', 'price'];

  public function ingredients()
  {
      return $this->belongsToMany('App\Ingredient');
  }
}
