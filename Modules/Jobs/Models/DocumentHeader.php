<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class DocumentHeader extends Model
{
    use HasFactory;

    protected $table = "jobs_document_headers";

    protected $fillable = ['document_id', 'title', 'encrypted_header'];
    
    public function setEncryptedHeaderAttribute($value)
    {
        $this->attributes['encrypted_header'] = Crypt::encryptString($value);
    }

    public function getDecryptedHeaderAttribute()
    {
        return Crypt::decryptString($this->attributes['encrypted_header']);
    }
    public function body()
    {
        return $this->hasOne(DocumentBody::class, 'document_id', 'document_id');
    }
}
