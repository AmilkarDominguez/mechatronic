<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $fillable = [
        'ci',
        'expedition_ci',
        'code_ci',
        'name',
        'lastname',
        'address',
        'num_address',
        'date_birth',
        'gender_id',
    ];
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function gender()
    {
        return $this->hasOne(Gender::class);
    }
}
