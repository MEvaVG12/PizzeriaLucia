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

    public function pizzas()
    {
        return $this->belongsTo('App\Pizza');
    }

}
