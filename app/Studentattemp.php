<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Studentattemp extends Model
{    
    protected $fillable = ['user_id', 'questionset_id', 'attempt','	last_attemptdate']; 
	
	
}
