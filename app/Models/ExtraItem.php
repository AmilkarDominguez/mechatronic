<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'cost',
        'price',
        'slug',
        'state'
    ];
}
