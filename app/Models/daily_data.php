<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class daily_data extends Model
{
    use HasFactory;
    protected $table = 'daily_data';
    protected $fillable = [
        'voucher_date', 'ac_head', 'control_ac', 'sub_ac'
    ];
}
