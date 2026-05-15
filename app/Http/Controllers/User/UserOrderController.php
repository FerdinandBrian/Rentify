<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserOrderController extends Controller
{
    public function __construct(private readonly UserOrderService $orderService) {}

    public function index(Request $request)
    {
        $filters = $request->validate([
            'status' => ['nullable', 'string'],
        ]);

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => ['required', Rule::exists('car', 'series_number')],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $order = $this->orderService->createPendingOrderForCarSeries(
            Auth::user(),
            $validated['car_id'],
            $validated['start_date'],
            $validated['end_date']
        );

        if (! $order) {
            return back()->with('error', 'Mobil tidak tersedia pada rentang tanggal tersebut.');
        }

        return redirect()->route('user.orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat dan menunggu konfirmasi admin.');
    }

    public function cancel(string $id)
    {
        $this->orderService->cancelPendingOrder(Auth::user(), $id);

        return redirect()->route('user.orders.show', $id)
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
