<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'total',
        'slug',
        'state',
        'payment_type',
        'customer_id',
        'user_id',
        'warehouse_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
