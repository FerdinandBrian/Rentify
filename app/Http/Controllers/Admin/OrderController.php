<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\BookingNotFoundException;
use App\Exceptions\InvalidFilterException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderIndexRequest;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Services\Orders\OrderService;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService) {}

    public function index(OrderIndexRequest $request)
    {
        try {
            $orders = $this->orderService->getBookingsWithPagination($request->validated());
        } catch (InvalidFilterException $exception) {
            return back()->withErrors(['status' => $exception->getMessage()]);
        }

        return view('Admin.Pesanan.index', compact('orders'));
    }

    public function show(string $id)
    {
        try {
            $order = $this->orderService->getBookingDetail($id);
        } catch (BookingNotFoundException $exception) {
            abort(404, $exception->getMessage());
        }

        return view('Admin.Pesanan.show', compact('order'));
    }

    public function edit(string $id)
    {
        try {
            $order = $this->orderService->getBookingDetail($id);
        } catch (BookingNotFoundException $exception) {
            abort(404, $exception->getMessage());
        }

        return view('Admin.Pesanan.edit', compact('order'));
    }

    public function update(UpdateOrderRequest $request, string $id)
    {
        try {
            $this->orderService->updateBooking($id, $request->validated());
        } catch (BookingNotFoundException $exception) {
            return back()->withErrors(['booking' => $exception->getMessage()]);
        }

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        try {
            $this->orderService->deleteBooking($id);
        } catch (BookingNotFoundException $exception) {
            return back()->withErrors(['booking' => $exception->getMessage()]);
        }

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function approve(string $id)
    {
        try {
            $this->orderService->approveBooking($id);
        } catch (BookingNotFoundException $exception) {
            return back()->withErrors(['booking' => $exception->getMessage()]);
        }

        return redirect()->route('orders.show', $id)->with('success', 'Pesanan berhasil disetujui dan pembayaran telah dibuat.');
    }

    public function reject(string $id)
    {
        try {
            $this->orderService->rejectBooking($id);
        } catch (BookingNotFoundException $exception) {
            return back()->withErrors(['booking' => $exception->getMessage()]);
        }

        return redirect()->route('orders.show', $id)->with('success', 'Pesanan telah ditolak.');
    }
}
