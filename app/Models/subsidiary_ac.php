<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subsidiary_ac extends Model
{
    use HasFactory;

    protected $table = 'subsidiary_ac';
    protected $fillable = [
        'accounts_group', 'account_id', 'account_name'
    ];
}
