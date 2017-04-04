<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $table = "products";
  protected $fillable = ['name', 'price', 'product_types_id'];

  public function ingredients()
  {
      return $this->belongsToMany('App\Ingredient');
  }

  public function productType()
  {
      return $this->belongsTo('App\ProductType');
  }
}
