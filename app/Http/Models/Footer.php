<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
  protected $connection = 'mysql';

    protected $table= 'footer';
    protected $fillable = array(

    );
    public $timestamps = false;
}
