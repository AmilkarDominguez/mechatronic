<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'service_order_id',
        'slug',
        'state',
    ];
    public function service_order()
    {
        return $this->belongsTo(ServiceOrder::class);
    }
}
