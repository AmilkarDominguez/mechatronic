<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ServiceOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'description',
        'total',
        'have',
        'must',
        'mileage',
        'draft_expiration_date',
        'started_date',
        'ended_date',
        'slug',
        'state',
        'payment_type',
        'customer_id',
        'vehicle_id',
        'user_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDraftExpirationDateFormattedAttribute()
    {
        return $this->draft_expiration_date ? Carbon::parse($this->draft_expiration_date)->format('d/m/Y') : null;
    }

    public function getStartedDateFormattedAttribute()
    {
        return $this->started_date ? Carbon::parse($this->started_date)->format('d/m/Y') : null;
    }

    public function getEndedDateFormattedAttribute()
    {
        return $this->ended_date ? Carbon::parse($this->ended_date)->format('d/m/Y') : null;
    }
}
