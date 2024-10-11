<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyOpeningBalance extends Model
{
    use HasFactory;
    protected $table = 'daily_oppening_balance';

    protected $fillable = [
        'date',
        'ac_head',
    ];
}
