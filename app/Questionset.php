<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Questionset extends Model
{    
    protected $fillable = ['title', 'description', 'numofques','level','passnum','time','scheduled_at'];

    public function user()
    {
        return $this->belongsTo(\App\User::class,'reqreciever_id');
    }
	
	
}
