<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  protected $fillable = [
      'yelp_id', 'date',
  ];

  public function users()
  {
    return $this->hasMany(UserEventStatus::class);
  }
}
