<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'person_id',
        'customer_type_id',
        'description',
        'birthday',
        'email',
        'nit',
        'slug',
        'state'
    ];
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
    public function customer_type()
    {
        return $this->belongsTo(CustomerType::class);
    }
}
