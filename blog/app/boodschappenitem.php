<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class boodschappenitem extends Model
{
    protected $table = 'boodschappenitem';
    public $timestamps = false;
    protected $fillable = [
      'naam',
      'aantal',
    ];
}
