<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        try {
            $documents = Document::query()
                ->with('user')
                ->latest()
                ->get();

            return view('Admin.Dokumen.index', compact('documents'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->withErrors(['error' => 'Gagal memuat dokumen pelanggan: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $document = Document::query()
                ->with('user')
                ->findOrFail($id);

            return view('Admin.Dokumen.show', compact('document'));
        } catch (\Exception $e) {
            return redirect()->route('documents.index')->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function changeStatus($id, Request $request)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,approved,rejected',
            ]);

            $document = Document::query()->findOrFail($id);
            $document->update(['status' => $validated['status']]);

            return redirect()->route('documents.index')->with('success', 'Status dokumen berhasil diubah.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengubah status dokumen: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $document = Document::query()->findOrFail($id);

            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $document->delete();

            return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus dokumen: ' . $e->getMessage()]);
        }
    }
}
