<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreReturnRequest;
use App\Services\Returns\ReturnService;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ReturnController extends Controller
{
    public function __construct(private readonly ReturnService $returnService) {}

    public function index(Request $request)
    {
        $activeOrders = $this->returnService->getActiveOrdersWithPagination(10);
        $completedOrders = $this->returnService->getCompletedOrdersWithPagination(10);

        return view('Admin.Returns.index', compact('activeOrders', 'completedOrders'));
    }

    public function create(string $orderId)
    {
        try {
            $order = $this->returnService->getActiveOrderDetail($orderId);
        } catch (InvalidArgumentException $e) {
            return redirect()->route('returns.index')->with('error', $e->getMessage());
        }

        return view('Admin.Returns.create', compact('order'));
    }

    public function store(StoreReturnRequest $request)
    {
        $validated = $request->validated();

        try {
            $order = $this->returnService->processReturn($validated);
        } catch (InvalidArgumentException $e) {
            return redirect()->route('returns.index')->with('error', $e->getMessage());
        }

        return redirect()->route('returns.show', $order->id)->with('success', 'Pengembalian mobil berhasil diproses. Silakan cek pembayaran customer.');
    }

    public function show(string $id)
    {
        try {
            $order = $this->returnService->getCompletedOrderDetail($id);
        } catch (InvalidArgumentException $e) {
            return redirect()->route('returns.index')->with('error', $e->getMessage());
        }

        $paymentSummary = $this->returnService->calculateReturnPayment($order);

        return view('Admin.Returns.show', compact('order', 'paymentSummary'));
    }
}
