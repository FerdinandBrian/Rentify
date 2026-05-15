<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Car;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['car', 'user'])->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $cars = Car::where('status', 'available')->get();
        return view('orders.create', compact('cars'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id'                => 'required|unique:order,id',
            'name'              => 'required',
            'call_number'       => 'required',
            'email'             => 'nullable|email',
            'status'            => 'required',
            'start_rent'        => 'required|date',
            'end_rent'          => 'required|date|after:start_rent',
            'Car_series_number' => 'required|exists:car,series_number',
            'User_id'           => 'required|exists:users,id',
        ]);

        Order::create($validated);
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat.');
    }

    public function show($id)
    {
        $order = Order::with(['car', 'user', 'payments'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $cars = Car::all();
        return view('orders.edit', compact('order', 'cars'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $validated = $request->validate([
            'name'        => 'required',
            'call_number' => 'required',
            'status'      => 'required',
            'start_rent'  => 'required|date',
            'end_rent'    => 'required|date|after:start_rent',
        ]);

        $order->update($validated);
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
