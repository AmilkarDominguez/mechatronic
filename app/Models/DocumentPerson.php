<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentPerson extends Model
{
    use HasFactory;
    protected $fillable = [
        'person_id',
        'document_type_id',
        'document_number',
        'document_issuance',
        'document_supplement',
    ];
    public function people()
    {
        return $this->belongsTo(Person::class);
    }
    public function identitydocumenttype()
    {
        return $this->belongsTo(IdentityDocumentType::class);
    }
}
