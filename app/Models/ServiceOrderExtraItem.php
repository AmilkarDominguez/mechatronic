<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceOrderExtraItem extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'cost',
        'price',
        'quantity',
        'subtotal',
        'extra_item_id',
        'service_order_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function extra_item()
    {
        return $this->belongsTo(ExtraItem::class);
    }
    public function service_order()
    {
        return $this->belongsTo(ServiceOrder::class);
    }
}
