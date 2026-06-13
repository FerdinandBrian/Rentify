<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CarCatalogIndexRequest;
use App\Services\User\UserCarCatalogService;
use Illuminate\Support\Facades\Auth;

class UserCarController extends Controller
{
    public function __construct(private readonly UserCarCatalogService $carCatalogService) {}

    public function index(CarCatalogIndexRequest $request)
    {
        $filters = $request->validated();

        return view('user.cars.index', $this->carCatalogService->catalogData($filters));
    }

    public function show(string $id)
    {
        return view('user.cars.show', $this->carCatalogService->detailData($id, Auth::id()));
    }
}
