<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'slug',    
        'type',    
        'state',
        'allow_deletion'
    ];
}