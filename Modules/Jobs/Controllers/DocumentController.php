<?php

namespace Modules\Jobs\Controllers;

use App\Http\Controllers\Controller;
use Modules\Jobs\Services\DocumentService;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    protected $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * Upload a new document
     */
    public function upload(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'header' => 'required|string',
            'body' => 'required|string',
        ]);

        $documentId = $this->documentService->uploadDocument($validated);

        return response()->json(['message' => 'Document uploaded successfully', 'document_id' => $documentId], 201);
    }

    /**
     * View a document by combining header and body
     */
    public function view($id)
    {
        $document = $this->documentService->viewDocument($id);

        if (!$document) {
            return response()->json(['error' => 'Document not found'], 404);
        }

        return response()->json($document);
    }

    /**
     * List all documents with metadata
     */
    public function list()
    {
        $documents = $this->documentService->listDocuments();

        return response()->json($documents);
    }
}
