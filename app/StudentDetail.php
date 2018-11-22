<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentDetail extends Model
{
    protected $fillable = ['user_id','registeredfor', 'fatherName', 'fatherOccupation','dob','current_class','genaddressder','city','state','pincode','schoolName','schoolAddress','prefer_location','profilepic','sourcedetail','enrollmentid','ispaymentdone','gender']; 
}
