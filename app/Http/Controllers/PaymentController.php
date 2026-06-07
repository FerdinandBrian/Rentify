<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Services\RootCrud\PaymentService;

class PaymentController extends Controller
{
    public function __construct(private readonly PaymentService $paymentService) {}

    public function index()
    {
        $payments = $this->paymentService->allWithOrder();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $orders = $this->paymentService->pendingOrders();
        return view('payments.create', compact('orders'));
    }

    public function store(StorePaymentRequest $request)
    {
        $this->paymentService->create($request->validated());
        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function show($id)
    {
        $payment = $this->paymentService->getDetail($id);
        return view('payments.show', compact('payment'));
    }

    public function update(UpdatePaymentRequest $request, $id)
    {
        $this->paymentService->update($id, $request->validated());
        return redirect()->route('payments.index')->with('success', 'Status pembayaran diperbarui.');
    }

    public function destroy($id)
    {
        $this->paymentService->delete($id);
        return redirect()->route('payments.index')->with('success', 'Data pembayaran dihapus.');
    }
}
