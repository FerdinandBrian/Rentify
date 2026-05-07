<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Psr7\Request;

class DocumentController extends Controller
{
    public function index(){
        $users = User::where('role_id', 3)->get();
        return view('Admin.Dokumen.index', compact('users'));
    }

    public function show($id){
        $user = User::findOrFail($id);
        return view('Admin.Dokumen.show', compact('user'));
    }

    public function changeStatus($id, Request $request){
        $user = User::findOrFail($id);
        $user->update(['status' => $request->status]);
        return redirect()->route('documents.index')->with('success', 'Status dokumen berhasil diubah.'); 
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->update(['document' => null, 'status' => null]);
        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}

