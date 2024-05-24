<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'expense_type_id',
        'purchase',
        'description',
        'slug',
        'state',
    ];
    public function expense_type()
    {
        return $this->belongsTo(ExpenseType::class);
    }
}
