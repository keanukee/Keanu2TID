<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryey = 'pelanggan_id';
    protected $fillable = [
        'first_name' ,
        'last_name' ,
        'birthday' ,
        'gender' ,
        'email' ,
        'phone' ,
    ];
}

