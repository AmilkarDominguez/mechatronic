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
        'sale_id'
    ];

    public $incrementing = false;

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
