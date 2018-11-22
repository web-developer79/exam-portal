<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Studentquestionpaper extends Model
{    
    protected $fillable = ['user_id', 'questionset_id', 'result', 'default_time', 'time_spent', 'is_complete'];   
	
	
}
