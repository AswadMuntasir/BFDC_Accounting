<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearlyOpeningBalance extends Model
{
    use HasFactory;
    protected $table = 'yearly_opening_balance';

    protected $fillable = [
        'date',
        'ac_head',
    ];
}
