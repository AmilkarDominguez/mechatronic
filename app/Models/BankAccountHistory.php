<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccountHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'bank_account_id',
        'user_id',
        'amount',
        'balance'
    ];
    public function bank_account()
    {
        return $this->belongsTo(BankAccount::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
