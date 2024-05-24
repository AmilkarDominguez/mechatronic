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
        'address',
        'print_logo',
        'slug',
    ];
}
