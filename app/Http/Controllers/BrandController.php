<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id'   => 'required|integer|unique:brand,id',
            'name' => 'required',
        ]);

        Brand::create($validated);
        return redirect()->route('brands.index')->with('success', 'Brand berhasil ditambahkan.');
    }

    public function show($id)
    {
        $brand = Brand::with('cars')->findOrFail($id);
        return view('brands.show', compact('brand'));
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $brand->update($validated);
        return redirect()->route('brands.index')->with('success', 'Brand berhasil diupdate.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand berhasil dihapus.');
    }
}
