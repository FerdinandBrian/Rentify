<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDendaRequest;
use App\Http\Requests\Admin\UpdateDendaRequest;
use App\Services\Denda\DendaService;
use InvalidArgumentException;

class DendaController extends Controller
{
    public function __construct(private readonly DendaService $dendaService) {}

    public function index()
    {
        return view('Admin.Denda.index', [
            'dendas' => $this->dendaService->getDendaWithPagination(10),
        ]);
    }

    public function create()
    {
        return view('Admin.Denda.create', [
            'formOptions' => $this->dendaService->getDendaFormOptions(),
        ]);
    }

    public function store(StoreDendaRequest $request)
    {
        try {
            $this->dendaService->createDenda($request->validated());
        } catch (InvalidArgumentException $exception) {
            return back()->withInput()->withErrors(['denda' => $exception->getMessage()]);
        }

        return redirect()->route('denda.index')->with('success', 'Denda berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        try {
            $denda = $this->dendaService->getDendaDetail($id);
        } catch (InvalidArgumentException $exception) {
            return redirect()->route('denda.index')->withErrors(['denda' => $exception->getMessage()]);
        }

        return view('Admin.Denda.edit', [
            'denda' => $denda,
            'formOptions' => $this->dendaService->getDendaFormOptions(),
        ]);
    }

    public function update(UpdateDendaRequest $request, int $id)
    {
        try {
            $this->dendaService->updateDenda($id, $request->validated());
        } catch (InvalidArgumentException $exception) {
            return back()->withInput()->withErrors(['denda' => $exception->getMessage()]);
        }

        return redirect()->route('denda.index')->with('success', 'Denda berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        try {
            $this->dendaService->deleteDenda($id);
        } catch (InvalidArgumentException $exception) {
            return back()->withErrors(['denda' => $exception->getMessage()]);
        }

        return redirect()->route('denda.index')->with('success', 'Denda berhasil dihapus.');
    }
}
