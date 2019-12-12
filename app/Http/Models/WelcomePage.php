<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomePage extends Model
{
  protected $connection = 'mysql';

    protected $table= 'welcome_page';
    protected $fillable = array(

    );
    public $timestamps = false;
}
