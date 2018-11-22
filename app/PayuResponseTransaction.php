<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayuResponseTransaction extends Model
{
    protected $fillable = ['txnid','payumoneyid', 'status', 'unmappedstatus', 'addedon', 'field9', 'bankrefnum','bankcode', 'error', 'errormessage', 'tracking_message', 'mihpayid' ]; 
}
