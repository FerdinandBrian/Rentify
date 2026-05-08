<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CarRepositoryInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Services\CarFactory;
use Illuminate\Http\Request;

class CarController extends Controller
{
    protected $carRepository;
    protected $brandRepository;
    protected $carFactory;

    public function __construct(
        CarRepositoryInterface $carRepository,
        BrandRepositoryInterface $brandRepository,
        CarFactory $carFactory
    ) {
        $this->carRepository = $carRepository;
        $this->brandRepository = $brandRepository;
        $this->carFactory = $carFactory;
    }

    public function index()
    {
        $cars = $this->carRepository->getAllWithBrands();
        return view('admin.mobil.index', compact('cars'));
    }

    public function create()
    {
        $brands = $this->brandRepository->all();
        $types = $this->carRepository->getUniqueTypes();
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
            'is_electric'   => 'boolean',
        ]);

        $validated['is_electric'] = $request->has('is_electric');

        try {
            $this->carFactory->createCar($validated);
            return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit($series_number)
    {
        $car = $this->carRepository->findById($series_number);
        if (!$car) {
            abort(404);
        }

        $brands = $this->brandRepository->all();
        $types = $this->carRepository->getUniqueTypes();
        return view('admin.mobil.edit', compact('car', 'brands', 'types'));
    }

    public function update(Request $request, $series_number)
    {
        $car = $this->carRepository->findById($series_number);
        if (!$car) {
            abort(404);
        }

        $validated = $request->validate([
            'name'     => 'required',
            'price'    => 'required|numeric',
            'type'     => 'required',
            'year'     => 'nullable|date',
            'status'   => 'required',
            'Brand_id' => 'required|exists:brand,id',
            'is_electric' => 'boolean',
        ]);

        $validated['is_electric'] = $request->has('is_electric');

        try {
            $this->carFactory->updateCar($car, $validated);
            return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy($series_number)
    {
        $this->carRepository->delete($series_number);
        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil dihapus.');
    }
}