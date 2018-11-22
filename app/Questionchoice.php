<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Questionchoice extends Model
{    
    protected $fillable = ['question_id', 'choice'];   
	
	
}
