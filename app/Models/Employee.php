<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'person_id',
        'description',
        'email',
        'nit',
        'slug',
        'state'
    ];
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
