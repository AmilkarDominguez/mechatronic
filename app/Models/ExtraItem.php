<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'item',
        'cost',
        'price',
        'quantity',
        'subtotal',
        'service_order_id'
    ];

    public $incrementing = false;

    public function service_order()
    {
        return $this->belongsTo(ServiceOrder::class);
    }
}
