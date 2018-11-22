<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentTransaction extends Model
{
    protected $fillable = ['user_id','enrollmentid', 'phone', 'email', 'txnid', 'hash' ]; 
}
