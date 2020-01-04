<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
  protected $connection = 'mysql';

    protected $table= 'service';
    protected $fillable = array(

    );
    public $timestamps = false;

    public static function getServices()
    {
        return Services::all()->random(4);
    }
}
