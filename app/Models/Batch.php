<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'supplier_id',
        'industry_id',
        'wholesale_price',
        'retail_price',
        'final_price',
        'stock',
        'description',
        'brand',
        'model',
        'expiration_date',
        'slug',
        'state'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
