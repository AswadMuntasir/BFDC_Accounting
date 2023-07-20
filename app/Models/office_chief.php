<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class office_chief extends Model
{
    use HasFactory;
    protected $table = 'office_chief';
    protected $fillable = [
        'department', 'office_chief_code'
    ];
}
