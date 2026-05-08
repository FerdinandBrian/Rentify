<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\AddOnRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddOnController extends Controller
{
    protected $addOnRepository;

    public function __construct(AddOnRepositoryInterface $addOnRepository)
    {
        $this->addOnRepository = $addOnRepository;
    }

    public function index()
    {
        $addons = $this->addOnRepository->all();
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

        $this->addOnRepository->create($validated);

        return redirect()->route('admin.addons.index')
            ->with('success', 'AddOn berhasil ditambahkan.');
    }

    public function show($id)
    {
        $addon = $this->addOnRepository->findById($id);
        if (!$addon) {
            abort(404);
        }
        return view('admin.addons.show', compact('addon'));
    }

    public function edit($id)
    {
        $addon = $this->addOnRepository->findById($id);
        if (!$addon) {
            abort(404);
        }
        return view('admin.addons.edit', compact('addon'));
    }

    public function update(Request $request, $id)
    {
        $addon = $this->addOnRepository->findById($id);
        if (!$addon) {
            abort(404);
        }

        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'price_per_unit' => 'nullable|numeric|min:0',
            'price_per_day'  => 'nullable|numeric|min:0',
        ]);

        $this->addOnRepository->update($addon, $validated);

        return redirect()->route('admin.addons.index')
            ->with('success', 'AddOn berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->addOnRepository->delete($id);

        return redirect()->route('admin.addons.index')
            ->with('success', 'AddOn berhasil dihapus.');
    }
}