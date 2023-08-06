<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class voucher_entry extends Model
{
    use HasFactory;

    protected $table = 'voucher_entry';
    protected $fillable = [
        'voucher_type', 'voucher_no', 'type', 'branch', 'voucher_date', 'party', 'receiver', 'description', 'dr_amount', 'cr_amount', 'cr_dr', 'total_dr_amount', 'total_cr_amount', 'vat', 'tax'
    ];

    public function subsidiaryAc()
    {
        return $this->belongsTo('App\Models\subsidiary_ac', 'subsidiary_ac_id');
    }
}
