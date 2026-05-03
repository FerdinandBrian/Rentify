<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Brand;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::with('brand')->get();
        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('cars.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'series_number' => 'required|unique:car,series_number',
            'name'          => 'required',
            'price'         => 'required|numeric',
            'type'          => 'required',
            'year'          => 'nullable|date',
            'status'        => 'required',
            'Brand_id'      => 'required|exists:brand,id',
        ]);

        Car::create($validated);
        return redirect()->route('cars.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    public function show($series_number)
    {
        $car = Car::with('brand')->findOrFail($series_number);
        return view('cars.show', compact('car'));
    }

    public function edit($series_number)
    {
        $car = Car::findOrFail($series_number);
        $brands = Brand::all();
        return view('cars.edit', compact('car', 'brands'));
    }

    public function update(Request $request, $series_number)
    {
        $car = Car::findOrFail($series_number);
        $validated = $request->validate([
            'name'     => 'required',
            'price'    => 'required|numeric',
            'type'     => 'required',
            'year'     => 'nullable|date',
            'status'   => 'required',
            'Brand_id' => 'required|exists:brand,id',
        ]);

        $car->update($validated);
        return redirect()->route('cars.index')->with('success', 'Mobil berhasil diupdate.');
    }

    public function destroy($series_number)
    {
        $car = Car::findOrFail($series_number);
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'Mobil berhasil dihapus.');
    }
}
