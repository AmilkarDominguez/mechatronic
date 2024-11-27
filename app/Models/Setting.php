<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'logo',
        'description',
        'email',
        'telephone',
        'nro_whatsapp',
        'url_facebook',
        'url_instagram',
        'url_website',
        'url_tiktok',
        'url_1',
        'url_2',
        'address',
        'print_logo',
        'service_order_number',
        'slug',
    ];
}
