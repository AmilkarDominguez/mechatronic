<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabourDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'employee_percentage',
        'price',
        'quantity',
        'subtotal',
        'employee_id',
        'service_id',
        'sale_id'
    ];

    public $incrementing = false;
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
