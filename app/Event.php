<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  protected $fillable = [
      'yelp_id', 'start_date',
  ];

  public function users()
  {
    return $this->belongsToMany('App\User')
      ->withTimestamps();
  }

}
