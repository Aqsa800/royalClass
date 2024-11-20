<?php

namespace Modules\Jobs\Services;

use Illuminate\Support\Facades\Crypt;
use Modules\Jobs\Models\DocumentHeader;
use Modules\Jobs\Models\DocumentBody;
use Illuminate\Support\Str;
class DocumentService
{
    /**
     * Upload a document by saving the encrypted header and body
     */
    public function uploadDocument(array $data)
    {
        $documentId = Str::uuid();

        $encryptedHeader = Crypt::encryptString($data['header']);
        $encryptedBody = Crypt::encryptString($data['body']);

        DocumentHeader::create([
            'document_id' => $documentId,
            'title' => $data['title'],
            'encrypted_header' => $encryptedHeader,
        ]);

        DocumentBody::create([
            'document_id' => $documentId,
            'encrypted_body' => $encryptedBody,
        ]);

        return $documentId;
    }

    /**
     * Retrieve and decrypt the document header and body
     */
    public function viewDocument(string $documentId)
    {
        $header = DocumentHeader::where('document_id', $documentId)->first();
        $body = DocumentBody::where('document_id', $documentId)->first();

        if (!$header || !$body) {
            return null;
        }

        $decryptedHeader = Crypt::decryptString($header->encrypted_header);
        $decryptedBody = Crypt::decryptString($body->encrypted_body);

        return [
            'title' => $header->title,
            'content' => $decryptedHeader . "\n\n" . $decryptedBody,
        ];
    }

    /**
     * List all document headers with metadata
     */
    public function listDocuments()
    {
        return DocumentHeader::select('document_id', 'title', 'created_at')
                             ->with('body')
                             ->get();
    }
}
