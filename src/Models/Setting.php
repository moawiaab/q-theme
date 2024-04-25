<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'exp_roof',
        'exp_conf',
        'account_id',
        'order_conf',
        'order_sup_conf',
        'order_back_conf',
        'locker_conf'
    ];
}
