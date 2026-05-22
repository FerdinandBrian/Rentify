<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CarRepositoryInterface;
use App\Services\CarFactory;
use App\Services\CarImageService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    protected $carRepository;
    protected $brandRepository;
    protected $carFactory;
    protected $carImageService;

    public function __construct(
        CarRepositoryInterface $carRepository,
        BrandRepositoryInterface $brandRepository,
        CarFactory $carFactory,
        CarImageService $carImageService
    ) {
        $this->carRepository = $carRepository;
        $this->brandRepository = $brandRepository;
        $this->carFactory = $carFactory;
        $this->carImageService = $carImageService;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['brand_id', 'type']);
            $cars = $this->carRepository->getFilteredWithBrands($filters);
            $brands = $this->brandRepository->all();
            $types = $this->carRepository->getUniqueTypes();

            return view('admin.mobil.index', compact('cars', 'brands', 'types'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->withErrors(['error' => 'Gagal memuat data mobil: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            $brands = $this->brandRepository->all();
            $types = $this->carRepository->getUniqueTypes();

            return view('admin.mobil.create', compact('brands', 'types'));
        } catch (\Exception $e) {
            return redirect()->route('admin.cars.index')->withErrors(['error' => 'Gagal memuat form tambah mobil: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'series_number' => 'required|unique:car,series_number',
            'name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required',
            'year' => 'nullable|integer',
            'status' => 'required',
            'Brand_id' => 'required|exists:brand,id',
            'is_electric' => 'boolean',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $images = $request->file('images', []);
        $validated['is_electric'] = $request->has('is_electric');
        $validated['brand_id'] = $validated['Brand_id'];
        $validated = $this->normalizeCarPayload($validated);
        unset($validated['Brand_id'], $validated['images']);

        try {
            $car = $this->carFactory->createCar($validated);
            $this->carImageService->storeUploadedImages($car, $images, true);

            return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal menambahkan mobil: ' . $e->getMessage()]);
        }
    }

    public function show($series_number)
    {
        try {
            $car = $this->carRepository->findById($series_number);
            if (! $car) {
                return redirect()->route('admin.cars.index')->withErrors(['error' => 'Mobil tidak ditemukan.']);
            }

            $car->load(['brand', 'images']);

            return view('admin.mobil.show', compact('car'));
        } catch (\Exception $e) {
            return redirect()->route('admin.cars.index')->withErrors(['error' => 'Gagal memuat detail mobil: ' . $e->getMessage()]);
        }
    }

    public function edit($series_number)
    {
        try {
            $car = $this->carRepository->findById($series_number);
            if (! $car) {
                return redirect()->route('admin.cars.index')->withErrors(['error' => 'Mobil tidak ditemukan.']);
            }

            $car->load('images');
            $brands = $this->brandRepository->all();
            $types = $this->carRepository->getUniqueTypes();

            return view('admin.mobil.edit', compact('car', 'brands', 'types'));
        } catch (\Exception $e) {
            return redirect()->route('admin.cars.index')->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $series_number)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required',
            'year' => 'nullable|integer',
            'status' => 'required',
            'Brand_id' => 'required|exists:brand,id',
            'is_electric' => 'boolean',
            'primary_image_id' => 'nullable|integer|exists:car_images,id',
            'delete_image_ids' => 'nullable|array',
            'delete_image_ids.*' => 'integer|exists:car_images,id',
            'make_uploaded_primary' => 'nullable|boolean',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $primaryImageId = $request->integer('primary_image_id') ?: null;
        $deleteImageIds = $request->input('delete_image_ids', []);
        $makeUploadedPrimary = $request->boolean('make_uploaded_primary');
        $images = $request->file('images', []);

        $validated['is_electric'] = $request->has('is_electric');
        $validated['brand_id'] = $validated['Brand_id'];
        $validated = $this->normalizeCarPayload($validated);
        unset(
            $validated['Brand_id'],
            $validated['primary_image_id'],
            $validated['delete_image_ids'],
            $validated['make_uploaded_primary'],
            $validated['images']
        );

        try {
            $car = $this->carRepository->findById($series_number);
            if (! $car) {
                return redirect()->route('admin.cars.index')->withErrors(['error' => 'Mobil tidak ditemukan.']);
            }

            $car = $this->carFactory->updateCar($car, $validated);
            $this->carImageService->deleteImages($car, $deleteImageIds);

            if ($primaryImageId && ! in_array($primaryImageId, array_map('intval', $deleteImageIds), true)) {
                $this->carImageService->setPrimaryImage($car, $primaryImageId);
            }

            $this->carImageService->storeUploadedImages($car, $images, $makeUploadedPrimary);

            return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui mobil: ' . $e->getMessage()]);
        }
    }

    public function destroy($series_number)
    {
        try {
            $this->carRepository->delete($series_number);

            return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus mobil: ' . $e->getMessage()]);
        }
    }

    private function normalizeCarPayload(array $payload): array
    {
        if (array_key_exists('year', $payload)) {
            $payload['year'] = $payload['year']
                ? $payload['year'] . '-01-01'
                : null;
        }

        return $payload;
    }
}
