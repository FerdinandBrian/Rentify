<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        try {
            $users = $this->userRepository->getCustomers();
            return view('Admin.Dokumen.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->withErrors(['error' => 'Gagal memuat dokumen pelanggan: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userRepository->findById($id);
            if (!$user) {
                return redirect()->route('documents.index')->withErrors(['error' => 'Pelanggan tidak ditemukan.']);
            }
            return view('Admin.Dokumen.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('documents.index')->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function changeStatus($id, Request $request)
    {
        try {
            $user = $this->userRepository->findById($id);
            if (!$user) {
                return redirect()->route('documents.index')->withErrors(['error' => 'Pelanggan tidak ditemukan.']);
            }

            $this->userRepository->update($user, ['status' => $request->status]);
            return redirect()->route('documents.index')->with('success', 'Status dokumen berhasil diubah.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengubah status dokumen: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->userRepository->findById($id);
            if (!$user) {
                return redirect()->route('documents.index')->withErrors(['error' => 'Pelanggan tidak ditemukan.']);
            }

            $this->userRepository->update($user, ['document' => null, 'status' => null]);
            return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus dokumen: ' . $e->getMessage()]);
        }
    }
}

