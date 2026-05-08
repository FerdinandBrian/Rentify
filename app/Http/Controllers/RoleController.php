<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id'   => 'required|integer|unique:role,id',
            'name' => 'required',
        ]);

        Role::create($validated);
        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role dihapus.');
    }
}
