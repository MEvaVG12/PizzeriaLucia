<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
  protected $table = "promotions";
  protected $fillable = ['name', 'price'];

  public function products()
  {
      return $this->belongsToMany('App\Product');
  }
}
