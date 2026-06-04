<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    protected $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index()
    {
        $brands = $this->brandRepository->all();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(StoreBrandRequest $request)
    {
        $validated = $request->validated();

        try {
            $this->brandRepository->create($validated);
            return redirect()->route('brands.index')->with('success', 'Merek berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal menambahkan merek: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $brand = $this->brandRepository->findById($id);
            if (!$brand) {
                return redirect()->route('brands.index')->withErrors(['error' => 'Merek tidak ditemukan.']);
            }
            return view('admin.brands.edit', compact('brand'));
        } catch (\Exception $e) {
            return redirect()->route('brands.index')->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function update(UpdateBrandRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $brand = $this->brandRepository->findById($id);
            if (!$brand) {
                return redirect()->route('brands.index')->withErrors(['error' => 'Merek tidak ditemukan.']);
            }

            $this->brandRepository->update($brand, $validated);
            return redirect()->route('brands.index')->with('success', 'Merek berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui merek: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->brandRepository->delete($id);
            return redirect()->route('brands.index')->with('success', 'Merek berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus merek: ' . $e->getMessage()]);
        }
    }
}
