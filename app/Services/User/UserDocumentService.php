<?php

namespace App\Services\User;

use App\Models\Document;
use App\Models\User;
use App\Repositories\User\UserDocumentRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserDocumentService
{
    public function __construct(private readonly UserDocumentRepository $documentRepository) {}

    public function documentsFor(User $user)
    {
        return $this->documentRepository->allForUser($user->id);
    }

    public function documentFor(User $user, int $documentId): Document
    {
        return $this->documentRepository->findForUser($documentId, $user->id);
    }

    public function pendingDocumentFor(User $user, int $documentId): Document
    {
        return $this->documentRepository->findPendingForUser($documentId, $user->id);
    }

    public function storeFor(User $user, array $data, UploadedFile $file): Document
    {
        return $this->documentRepository->create([
            'user_id' => $user->id,
            'document_type' => $data['document_type'],
            'file_path' => $this->storeFile($file),
            'description' => $data['description'] ?? null,
            'status' => 'pending',
        ]);
    }

    public function updatePendingDocument(Document $document, array $data, ?UploadedFile $file = null): Document
    {
        $payload = [
            'document_type' => $data['document_type'],
            'description' => $data['description'] ?? null,
        ];

        if ($file) {
            $this->deleteFile($document);
            $payload['file_path'] = $this->storeFile($file);
            $payload['status'] = 'pending';
        }

        return $this->documentRepository->update($document, $payload);
    }

    public function deletePendingDocument(Document $document): void
    {
        $this->deleteFile($document);
        $this->documentRepository->delete($document);
    }

    public function download(Document $document): StreamedResponse
    {
        abort_unless(Storage::disk('public')->exists($document->file_path), 404, 'File tidak ditemukan.');

        $extension = pathinfo($document->file_path, PATHINFO_EXTENSION);
        $fileName = $document->document_type . '_' . $document->id . ($extension ? '.' . $extension : '');

        return Storage::disk('public')->download($document->file_path, $fileName);
    }

    private function storeFile(UploadedFile $file): string
    {
        $fileName = time() . '_' . $file->getClientOriginalName();

        return $file->storeAs('documents', $fileName, 'public');
    }

    private function deleteFile(Document $document): void
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
    }
}
