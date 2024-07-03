<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabourDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'uuid',
        'employee_percentage',
        'price',
        'quantity',
        'subtotal',
        'employee_id',
        'service_id',
        'service_order_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function service_order()
    {
        return $this->belongsTo(ServiceOrder::class);
    }
}
