<?php

namespace App\Http\Controllers\User;

use App\Exceptions\DocumentNotVerifiedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\OrderIndexRequest;
use App\Http\Requests\User\StoreOrderRequest;
use App\Services\User\UserCarCatalogService;
use App\Services\User\UserOrderService;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function __construct(
        private readonly UserOrderService $orderService,
        private readonly UserCarCatalogService $carCatalogService
    ) {}

    public function index(OrderIndexRequest $request)
    {
        $filters = $request->validated();

        return view('user.orders.index', [
            'orders' => $this->orderService->paginatedOrdersFor(Auth::user(), $filters['status'] ?? null),
            'statusFilters' => $this->orderService->statusFilters(),
        ]);
    }

    public function show(string $id)
    {
        return view('user.orders.show', [
            'order' => $this->orderService->orderDetailFor(Auth::user(), $id),
        ]);
    }

    public function create(string $carId)
    {
        if (! $this->orderService->hasApprovedDocument(Auth::user())) {
            return redirect()->route('user.cars.show', $carId)
                ->with('error', 'Anda harus memiliki dokumen yang disetujui sebelum membuat pesanan.');
        }

        return view('user.orders.create', $this->carCatalogService->detailData($carId, Auth::id()));
    }

    public function store(StoreOrderRequest $request)
    {
        if (! $this->orderService->hasApprovedDocument(Auth::user())) {
            return back()->with('error', 'Anda harus memiliki dokumen yang disetujui sebelum membuat pesanan.');
        }

        $validated = $request->validated();

        try {
            $result = $this->orderService->createPendingOrderForCarSeries(
                Auth::user(),
                $validated['car_id'],
                $validated['start_date'],
                $validated['end_date'],
                $validated['addon_ids'] ?? [],  // teruskan addon yang dipilih user
            );
        } catch (DocumentNotVerifiedException $e) {
            return back()->with('error', $e->getMessage());
        }

        if (! $result) {
            return back()->with('error', 'Mobil tidak tersedia pada rentang tanggal tersebut atau dokumen belum disetujui.');
        }

        // Flash estimasi biaya hasil kalkulasi Decorator Pattern ke session
        return redirect()->route('user.orders.show', $result['order']->id)
            ->with('success', 'Pesanan berhasil dibuat dan menunggu konfirmasi admin.')
            ->with('rental_description', $result['rental_description'])
            ->with('estimated_cost', $result['estimated_cost']);
    }

    public function cancel(string $id)
    {
        $this->orderService->cancelPendingOrder(Auth::user(), $id);

        return redirect()->route('user.orders.show', $id)
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
