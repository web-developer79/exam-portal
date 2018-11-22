<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class slot extends Model
{
    protected $fillable = ['timeslotid','fromtime','totime','totalseat', 'offlineseat']; 
}
