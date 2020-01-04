<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGuide extends Model
{
  protected $connection = 'mysql';

    protected $table= 'payment_guide';
    protected $fillable = array(

    );
    public $timestamps = false;

}
