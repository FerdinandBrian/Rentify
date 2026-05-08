<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Http\Request;
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
        return view('admin.TipeMobil.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.TipeMobil.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->brandRepository->create($validated);
        return redirect()->route('brands.index')->with('success', 'Brand berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $brand = $this->brandRepository->findById($id);
        if (!$brand) {
            abort(404);
        }
        return view('admin.TipeMobil.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = $this->brandRepository->findById($id);
        if (!$brand) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required',
        ]);

        $this->brandRepository->update($brand, $validated);
        return redirect()->route('brands.index')->with('success', 'Brand berhasil diupdate.');
    }

    public function destroy($id)
    {
        $this->brandRepository->delete($id);
        return redirect()->route('brands.index')->with('success', 'Brand berhasil dihapus.');
    }
}
