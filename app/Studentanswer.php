<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Studentanswer extends Model
{    
    protected $fillable = ['studentquestionpaper_id', 'question_id', 'questionanswer_id', 'result'];   
	
	
}
