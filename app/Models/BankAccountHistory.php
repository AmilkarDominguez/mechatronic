<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BankAccountHistory extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'bank_account_id',
        'transaction_type_id',
        'user_id',
        'amount',
        'balance',
        'transaction_reference'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function bank_account()
    {
        return $this->belongsTo(BankAccount::class);
    }
    public function transaction_type()
    {
        return $this->belongsTo(TransactionType::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
