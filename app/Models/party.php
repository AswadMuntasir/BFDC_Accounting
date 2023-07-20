<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class party extends Model
{
    use HasFactory;

    protected $table = 'party';
    protected $fillable = [
        'name', 'email', 'contact_person', 'contact_number', 'vat_number', 'party_type', 'address', 'opening_balance_date', 'opening_balance_type', 'opening_balance', 'description'
    ];
}
