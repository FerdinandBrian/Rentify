<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserCarCatalogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCarController extends Controller
{
    public function __construct(private readonly UserCarCatalogService $carCatalogService) {}

    public function index(Request $request)
    {
        $filters = $request->validate([
            'brand' => ['nullable', 'integer'],
            'type' => ['nullable', 'string'],
            'search' => ['nullable', 'string', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        return view('user.cars.index', $this->carCatalogService->catalogData($filters));
    }

    public function show(string $id)
    {
        return view('user.cars.show', $this->carCatalogService->detailData($id, Auth::id()));
    }
}
