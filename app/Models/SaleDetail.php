<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantity',
        'price',
        'discount',
        'subtotal',
        'state',
        'batch_id',
        'sale_id',
        'price_type'
    ];
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
