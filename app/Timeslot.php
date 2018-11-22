<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    protected $fillable = ['title','slotdate','prefer_location', 'status']; 
}
