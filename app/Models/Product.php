<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'description',
        'slug',
        'photo',
        'state',
        'category_id',
        'presentation_id'
    ];
    public function presentation()
    {
        return $this->belongsTo(ProductPresentation::class);
    }
}
