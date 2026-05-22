<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDocumentController extends Controller
{
    public function __construct(private readonly UserDocumentService $documentService) {}

    public function index()
    {
        return view('user.documents.index', [
            'documents' => $this->documentService->documentsFor(Auth::user()),
        ]);
    }

    public function create()
    {
        return view('user.documents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_type' => 'required|in:KTP,SIM,STNK,Paspor',
            'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        $this->documentService->storeFor(Auth::user(), $validated, $request->file('document_file'));

        return redirect()->route('user.documents.index')
            ->with('success', 'Dokumen berhasil diunggah dan menunggu verifikasi.');
    }

    public function show(int $id)
    {
        return view('user.documents.show', [
            'document' => $this->documentService->documentFor(Auth::user(), $id),
        ]);
    }

    public function edit(int $id)
    {
        return view('user.documents.edit', [
            'document' => $this->documentService->pendingDocumentFor(Auth::user(), $id),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $document = $this->documentService->pendingDocumentFor(Auth::user(), $id);

        $validated = $request->validate([
            'document_type' => 'required|in:KTP,SIM,STNK,Paspor',
            'document_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        $this->documentService->updatePendingDocument($document, $validated, $request->file('document_file'));

        return redirect()->route('user.documents.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $document = $this->documentService->pendingDocumentFor(Auth::user(), $id);

        $this->documentService->deletePendingDocument($document);

        return redirect()->route('user.documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    public function download(int $id)
    {
        return $this->documentService->download(
            $this->documentService->documentFor(Auth::user(), $id)
        );
    }
}
