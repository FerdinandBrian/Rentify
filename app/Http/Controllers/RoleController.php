<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Services\RootCrud\RoleService;

class RoleController extends Controller
{
    public function __construct(private readonly RoleService $roleService) {}

    public function index()
    {
        $roles = $this->roleService->all();
        return view('roles.index', compact('roles'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->roleService->create($request->validated());
        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat.');
    }

    public function destroy($id)
    {
        $this->roleService->delete($id);
        return redirect()->route('roles.index')->with('success', 'Role dihapus.');
    }
}
