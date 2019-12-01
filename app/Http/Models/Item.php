<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
  protected $connection = 'mysql';

    protected $table= 'item';
    protected $fillable = array(

    );
    public $timestamps = false;

    // public function getBrand()
    // {
    // 	return $this->hasOne(Brand::class,'BRAND_CODE','ITEM_BRAND');
    // }

    // public function getType()
    // {
    // 	return $this->hasOne('App\Models\masterfile\ItemType','ITEM_TYPE_CODE','ITEM_TYPE');
    // }

    public static function getItems()
    {
        return Item::all()->random(4);
    }
}
