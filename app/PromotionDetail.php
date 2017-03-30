<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionDetail extends Model
{
    protected $table = "promotion_details";
    protected $fillable = ['amount','product_id', 'promotion_id'];

    public function product()
    {
      return $this->belongsTo('App\Product');
    }

    public function promotion()
    {
      return $this->belongsTo('App\Promotion');
    }
}
