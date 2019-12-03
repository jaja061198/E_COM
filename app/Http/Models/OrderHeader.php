<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHeader extends Model
{
  protected $connection = 'mysql';

    protected $table= 'order_header';
    protected $fillable = array(

    );
    public $timestamps = false;
}
