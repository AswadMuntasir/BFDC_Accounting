<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class control_ac extends Model
{
    use HasFactory;
    protected $table = 'control_ac';
    protected $fillable = [
        'accounts_group', 'subsidiary_account_name', 'account_id', 'account_name', 'ugc_priority', 'is_ugc_control_ac'
    ];
}
