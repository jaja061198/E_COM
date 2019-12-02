<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
  protected $connection = 'mysql';

    protected $table= 'cart';
    protected $fillable = array(

    );
    public $timestamps = false;
}
