<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = "ingredients";
    protected $fillable = ['name','type_id'];

    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

}
