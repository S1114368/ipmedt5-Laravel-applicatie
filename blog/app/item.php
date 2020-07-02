<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class item extends Model
{
    public $timestamps = false;
    use SoftDeletes;
    protected $fillable = [
      'user_id',
      'naam',
      'plank_positie',
      'barcode',
      'gewicht_huidig',
    ];
}
