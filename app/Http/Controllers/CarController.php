<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Brand;
use App\Services\CarFactory;        // tambah ini
use Illuminate\Http\Request;

class CarController extends Controller
{
    protected $factory;

    // Suntikkan Factory via Constructor (Laravel otomatis)
    public function __construct(CarFactory $factory)
    {
        $this->factory = $factory;
    }

    public function index()
    {
        $cars = Car::with('brand')->get();
        return view('admin.mobil.index', compact('cars'));
    }

    public function create()
    {
        $brands = Brand::all();
        $types = Car::select('type')->distinct()->orderBy('type')->pluck('type');
        return view('admin.mobil.create', compact('brands', 'types'));
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

        // Panggil Factory untuk membuat mobil (Controller tidak perlu tahu cara pembuatan)
        $this->factory->createCar($validated);

        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    public function edit($series_number)
    {
        $car = Car::where('series_number', $series_number)->firstOrFail();
        $brands = Brand::all();
        $types = Car::select('type')->distinct()->orderBy('type')->pluck('type');
        return view('admin.mobil.edit', compact('car', 'brands', 'types'));
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

        // Panggil Factory untuk update
        $this->factory->updateCar($car, $validated);

        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil diupdate.');
    }

    public function destroy($series_number)
    {
        $car = Car::findOrFail($series_number);
        $car->delete();
        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil dihapus.');
    }
}