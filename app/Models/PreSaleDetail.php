<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreSaleDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantity',
        'price',
        'discount',
        'subtotal',
        'state',
        'batch_id',
        'pre_sale_id',
        'price_type'
    ];
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function pre_sale()
    {
        return $this->belongsTo(PreSale::class);
    }
}
