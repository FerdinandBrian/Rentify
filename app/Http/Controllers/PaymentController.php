<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order')->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $orders = Order::where('status', 'pending')->get();
        return view('payments.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id'          => 'required|unique:payment,id',
            'method'      => 'required',
            'status'      => 'required',
            'total_price' => 'nullable|numeric',
            'Order_id'    => 'required|exists:order,id',
        ]);

        Payment::create($validated);
        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function show($id)
    {
        $payment = Payment::with(['order', 'addons', 'penaltyorder'])->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required',
        ]);

        $payment->update($validated);
        return redirect()->route('payments.index')->with('success', 'Status pembayaran diperbarui.');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Data pembayaran dihapus.');
    }
}
