<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEventStatus extends Model
{
    // the status for an event belongs to a specific user
    public function user()
    {
      return $this->belongsTo(User::class);
    }

    //the status of a user for an event belongs to a specific event. Currently, the presence of a
    //userEventStatus for a user indicates that they are attending. Future coudld be a user-modifiable
    //enum

    public function event()
    {
      return $this->belongsTo(Event::class);
    }
}
