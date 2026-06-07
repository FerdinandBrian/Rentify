<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangeDocumentStatusRequest;
use App\Models\Document;
use App\Models\User;

class DocumentController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', 3)
            ->with(['documents' => function ($q) {
                $q->latest();
            }])
            ->get();

        return view('Admin.Dokumen.index', compact('users'));
    }

    public function show($userId)
    {
        $user = User::where('role_id', 3)->with('documents')->findOrFail($userId);

        return view('Admin.Dokumen.show', compact('user'));
    }

    public function changeStatus($documentId, ChangeDocumentStatusRequest $request)
    {
        $validated = $request->validated();

        $document = Document::findOrFail($documentId);

        $document->update([
            'status' => $validated['status'],
            'rejection_reason' => $validated['status'] === 'rejected' ? ($validated['rejection_reason'] ?? null) : null,
        ]);

        return redirect()->route('documents.show', $document->user_id)
            ->with('success', 'Status dokumen berhasil diubah.');
    }

    public function destroy($documentId)
    {
        $document = Document::findOrFail($documentId);

        if ($document->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
