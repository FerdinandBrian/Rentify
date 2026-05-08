<?php

namespace App\Http\Controllers;

use App\Models\Penalty;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    public function index()
    {
        $penalties = Penalty::all();
        return view('penalties.index', compact('penalties'));
    }

    public function create()
    {
        return view('penalties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'          => 'required',
            'total_penalty' => 'required|numeric',
        ]);

        Penalty::create($validated);
        return redirect()->route('penalties.index')->with('success', 'Jenis denda berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penalty = Penalty::findOrFail($id);
        return view('penalties.edit', compact('penalty'));
    }

    public function update(Request $request, $id)
    {
        $penalty = Penalty::findOrFail($id);
        $validated = $request->validate([
            'type'          => 'required',
            'total_penalty' => 'required|numeric',
        ]);

        $penalty->update($validated);
        return redirect()->route('penalties.index')->with('success', 'Jenis denda diperbarui.');
    }

    public function destroy($id)
    {
        $penalty = Penalty::findOrFail($id);
        $penalty->delete();
        return redirect()->route('penalties.index')->with('success', 'Jenis denda dihapus.');
    }
}
