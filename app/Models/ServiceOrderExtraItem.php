<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrderExtraItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'cost',
        'price',
        'quantity',
        'subtotal',
        'extra_item_id',
        'service_order_id'
    ];
    
    public $incrementing = false;

    public function extra_item()
    {
        return $this->belongsTo(ExtraItem::class);
    }
    public function service_order()
    {
        return $this->belongsTo(ServiceOrder::class);
    }
}
