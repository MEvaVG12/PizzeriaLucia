<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionDetail extends Model
{
    protected $table = "PromotionDetails";
    protected $fillable = ['amount','product_id'];

    public function product()
    {
      return $this->belongsTo('App\Product');
    }

    public function promotion()
    {
      return $this->belongsTo('App\Promotion');
    }
}
