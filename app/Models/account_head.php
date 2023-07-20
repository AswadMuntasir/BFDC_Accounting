<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class account_head extends Model
{
    use HasFactory;
    protected $table = 'ac_head';
    protected $fillable = [
        'control_ac_id', 'ac_head_id', 'ac_head_name_eng', 'ac_head_name_ben', 'opening_balance', 'opening_balance_type', 'initialization_date', 'is_ugc_ac_head', 'is_status'
    ];
}
