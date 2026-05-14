<?php

namespace App\Repositories\User;

use App\Models\Document;
use Illuminate\Database\Eloquent\Collection;

class UserDocumentRepository
{
    public function allForUser(int $userId): Collection
    {
        return Document::query()
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function findForUser(int $documentId, int $userId): Document
    {
        return Document::query()
            ->where('user_id', $userId)
            ->findOrFail($documentId);
    }

    public function findPendingForUser(int $documentId, int $userId): Document
    {
        return Document::query()
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->findOrFail($documentId);
    }

    public function create(array $data): Document
    {
        return Document::query()->create($data);
    }

    public function update(Document $document, array $data): Document
    {
        $document->update($data);

        return $document->refresh();
    }

    public function delete(Document $document): void
    {
        $document->delete();
    }

    public function approvedCountForUser(int $userId): int
    {
        return Document::query()
            ->where('user_id', $userId)
            ->where('status', 'approved')
            ->count();
    }

    public function pendingCountForUser(int $userId): int
    {
        return Document::query()
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->count();
    }
}
