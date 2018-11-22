<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Question extends Model
{    
    protected $fillable = ['question', 'questiontype', 'questionset_id'];   
	
	public function questionchoice()
	{
		return $this->belongsTo(\App\Questionchoice::class,'question_id');
	}
	
}
