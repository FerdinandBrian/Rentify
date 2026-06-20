<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\RootCrud\OrderService;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService) {}

    public function index()
    {
        $orders = $this->orderService->allWithCarAndUser();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $cars = $this->orderService->availableCars();
        return view('orders.create', compact('cars'));
    }

    public function store(StoreOrderRequest $request)
    {
        $this->orderService->create($request->validated());
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat.');
    }

    public function show($id)
    {
        $order = $this->orderService->getById($id);
        return view('orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = $this->orderService->getById($id);
        $cars = $this->orderService->allCars();
        return view('orders.edit', compact('order', 'cars'));
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        $this->orderService->update($id, $request->validated());
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $this->orderService->delete($id);
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
