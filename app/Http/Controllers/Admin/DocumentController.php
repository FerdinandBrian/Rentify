<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function changeStatus($documentId, Request $request)
    {
        $request->validate([
            'status'           => 'required|in:approved,rejected',
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $document = Document::findOrFail($documentId);

        $document->update([
            'status'           => $request->status,
            'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null,
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
