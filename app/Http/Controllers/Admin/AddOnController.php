<?php

namespace App\Http\Controllers\Admin;

use App\Models\Addon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddOnController extends Controller
{
    public function index()
    {
        $addons = Addon::all();
        return view('admin.addons.index', compact('addons'));
    }

    public function create()
    {
        return view('admin.addons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'price_per_unit' => 'nullable|numeric|min:0',
            'price_per_day'  => 'nullable|numeric|min:0',
        ]);

        Addon::create($validated);

        return redirect()->route('admin.addons.index')
            ->with('success', 'AddOn berhasil ditambahkan.');
    }

    public function show($id)
    {
        $addon = Addon::findOrFail($id);
        return view('admin.addons.show', compact('addon'));
    }

    public function edit($id)
    {
        $addon = Addon::findOrFail($id);
        return view('admin.addons.edit', compact('addon'));
    }

    public function update(Request $request, $id)
    {
        $addon = Addon::findOrFail($id);

        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'price_per_unit' => 'nullable|numeric|min:0',
            'price_per_day'  => 'nullable|numeric|min:0',
        ]);

        $addon->update($validated);

        return redirect()->route('admin.addons.index')
            ->with('success', 'AddOn berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $addon = Addon::findOrFail($id);
        $addon->delete();

        return redirect()->route('admin.addons.index')
            ->with('success', 'AddOn berhasil dihapus.');
    }
}