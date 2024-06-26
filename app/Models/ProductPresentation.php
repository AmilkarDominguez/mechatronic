<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPresentation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'description',
        'slug',
        'state'
    ];
}
