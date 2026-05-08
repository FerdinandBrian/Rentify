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
        $users = $this->userRepository->getCustomers();
        return view('Admin.Dokumen.index', compact('users'));
    }

    public function show($id)
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            abort(404);
        }
        return view('Admin.Dokumen.show', compact('user'));
    }

    public function changeStatus($id, Request $request)
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            abort(404);
        }

        $this->userRepository->update($user, ['status' => $request->status]);
        return redirect()->route('documents.index')->with('success', 'Status dokumen berhasil diubah.');
    }

    public function destroy($id)
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            abort(404);
        }

        $this->userRepository->update($user, ['document' => null, 'status' => null]);
        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}

