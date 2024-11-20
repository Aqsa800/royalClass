<?php

namespace Modules\General\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class DocumentBody extends Model
{
    use HasFactory;

    protected $table = "general_document_bodies";
    
    protected $fillable = ['document_id', 'encrypted_body'];

    public function setEncryptedBodyAttribute($value)
    {
        $this->attributes['encrypted_body'] = Crypt::encryptString($value);
    }

    public function getDecryptedBodyAttribute()
    {
        return Crypt::decryptString($this->attributes['encrypted_body']);
    }
    public function header()
    {
        return $this->belongsTo(DocumentHeader::class, 'document_id', 'document_id');
    }
}
