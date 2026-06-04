<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenaltyRequest;
use App\Http\Requests\UpdatePenaltyRequest;
use App\Services\RootCrud\PenaltyService;

class PenaltyController extends Controller
{
    public function __construct(private readonly PenaltyService $penaltyService) {}

    public function index()
    {
        $penalties = $this->penaltyService->all();
        return view('penalties.index', compact('penalties'));
    }

    public function create()
    {
        return view('penalties.create');
    }

    public function store(StorePenaltyRequest $request)
    {
        $this->penaltyService->create($request->validated());
        return redirect()->route('penalties.index')->with('success', 'Jenis denda berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penalty = $this->penaltyService->getById($id);
        return view('penalties.edit', compact('penalty'));
    }

    public function update(UpdatePenaltyRequest $request, $id)
    {
        $this->penaltyService->update($id, $request->validated());
        return redirect()->route('penalties.index')->with('success', 'Jenis denda diperbarui.');
    }

    public function destroy($id)
    {
        $this->penaltyService->delete($id);
        return redirect()->route('penalties.index')->with('success', 'Jenis denda dihapus.');
    }
}
