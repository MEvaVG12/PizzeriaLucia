<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  protected $table = "sales";
  protected $fillable = ['client', 'phoneNumer', 'orderDate', 'deliveryDate', 'orderDateTime', 'deliveryDateTime'];

}
