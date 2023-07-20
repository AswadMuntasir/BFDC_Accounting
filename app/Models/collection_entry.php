<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class collection_entry extends Model
{
    use HasFactory;
    protected $table = 'collection_entry';
    protected $fillable = [
        'collection_date', 'bill_section', 'customer_name', 'collection_type', 'collection_amount', 'description', 'dr_amount', 'cr_amount'
    ];
}
