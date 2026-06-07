<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreAddOnRequest;
use App\Http\Requests\Admin\UpdateAddOnRequest;
use App\Repositories\Contracts\AddOnRepositoryInterface;
use App\Http\Controllers\Controller;

class AddOnController extends Controller
{
    protected $addOnRepository;

    public function __construct(AddOnRepositoryInterface $addOnRepository)
    {
        $this->addOnRepository = $addOnRepository;
    }

    public function index()
    {
        try {
            $addons = $this->addOnRepository->all();
            return view('admin.addons.index', compact('addons'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->withErrors(['error' => 'Gagal memuat data AddOn: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        return view('admin.addons.create');
    }

    public function store(StoreAddOnRequest $request)
    {
        $validated = $request->validated();

        try {
            $this->addOnRepository->create($validated);
            return redirect()->route('admin.addons.index')
                ->with('success', 'AddOn berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal menambahkan AddOn: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $addon = $this->addOnRepository->findById($id);
            if (!$addon) {
                return redirect()->route('admin.addons.index')->withErrors(['error' => 'AddOn tidak ditemukan.']);
            }
            return view('admin.addons.show', compact('addon'));
        } catch (\Exception $e) {
            return redirect()->route('admin.addons.index')->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $addon = $this->addOnRepository->findById($id);
            if (!$addon) {
                return redirect()->route('admin.addons.index')->withErrors(['error' => 'AddOn tidak ditemukan.']);
            }
            return view('admin.addons.edit', compact('addon'));
        } catch (\Exception $e) {
            return redirect()->route('admin.addons.index')->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function update(UpdateAddOnRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $addon = $this->addOnRepository->findById($id);
            if (!$addon) {
                return redirect()->route('admin.addons.index')->withErrors(['error' => 'AddOn tidak ditemukan.']);
            }

            $this->addOnRepository->update($addon, $validated);
            return redirect()->route('admin.addons.index')
                ->with('success', 'AddOn berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui AddOn: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->addOnRepository->delete($id);
            return redirect()->route('admin.addons.index')
                ->with('success', 'AddOn berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus AddOn: ' . $e->getMessage()]);
        }
    }
}
