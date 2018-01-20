<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Ixudra\Curl\Facades\Curl;



class AddressModel extends Model
{
    protected $table = 'pre_address';

    public $timestamps = false;

    protected $fillable = [
        'id','wallet_id', 'address', 'status', 'response','created_at'
    ];
}