<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddonRequest;
use App\Http\Requests\UpdateAddonRequest;
use App\Services\RootCrud\AddonService;

class AddonController extends Controller
{
    public function __construct(private readonly AddonService $addonService) {}

    public function index()
    {
        $addons = $this->addonService->all();
        return view('addons.index', compact('addons'));
    }

    public function create()
    {
        return view('addons.create');
    }

    public function store(StoreAddonRequest $request)
    {
        $this->addonService->create($request->validated());
        return redirect()->route('addons.index')->with('success', 'Addon berhasil ditambahkan.');
    }

    public function show($id)
    {
        $addon = $this->addonService->getById($id);
        return view('addons.show', compact('addon'));
    }

    public function edit($id)
    {
        $addon = $this->addonService->getById($id);
        return view('addons.edit', compact('addon'));
    }

    public function update(UpdateAddonRequest $request, $id)
    {
        $this->addonService->update($id, $request->validated());
        return redirect()->route('addons.index')->with('success', 'Addon berhasil diupdate.');
    }

    public function destroy($id)
    {
        $this->addonService->delete($id);
        return redirect()->route('addons.index')->with('success', 'Addon berhasil dihapus.');
    }
}
