<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    protected $fillable = ['enrollmentid', 'mobilenumber', 'studentname', 'schoolname', 'class', 'rank', 'examlocation', 'examdate']; 
}
