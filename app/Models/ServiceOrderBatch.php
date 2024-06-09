<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrderBatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'quantity',
        'price',
        'discount',
        'subtotal',
        'state',
        'batch_id',
        'service_order_id'
    ];
    
    public $incrementing = false;

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function service_order()
    {
        return $this->belongsTo(ServiceOrder::class);
    }
}
