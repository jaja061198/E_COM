<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
  protected $connection = 'mysql';

    protected $table= 'order_detail';
    protected $fillable = array(

    );
    public $timestamps = false;
}
