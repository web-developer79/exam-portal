<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionsPayU extends Model
{
    protected $fillable = ['txnid','payumoneyid', 'status', 'unmappedstatus', 'addedon', 'field9', 'bankrefnum', 'bankcode', 'error', 'errormessage', 'mihpayid']; 
}
