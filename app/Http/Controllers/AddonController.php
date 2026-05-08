<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function index()
    {
        $addons = Addon::all();
        return view('addons.index', compact('addons'));
    }

    public function create()
    {
        return view('addons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id'    => 'required|integer|unique:addon,id',
            'name'  => 'required',
            'price' => 'required|numeric',
        ]);

        Addon::create($validated);
        return redirect()->route('addons.index')->with('success', 'Addon berhasil ditambahkan.');
    }

    public function show($id)
    {
        $addon = Addon::findOrFail($id);
        return view('addons.show', compact('addon'));
    }

    public function edit($id)
    {
        $addon = Addon::findOrFail($id);
        return view('addons.edit', compact('addon'));
    }

    public function update(Request $request, $id)
    {
        $addon = Addon::findOrFail($id);
        $validated = $request->validate([
            'name'  => 'required',
            'price' => 'required|numeric',
        ]);

        $addon->update($validated);
        return redirect()->route('addons.index')->with('success', 'Addon berhasil diupdate.');
    }

    public function destroy($id)
    {
        $addon = Addon::findOrFail($id);
        $addon->delete();
        return redirect()->route('addons.index')->with('success', 'Addon berhasil dihapus.');
    }
}
