<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with(['car', 'user'])->get();
        return view('feedbacks.index', compact('feedbacks'));
    }

    public function store(StoreFeedbackRequest $request, string $order)
    {
        $order = Order::query()
            ->with('feedback')
            ->where('User_id', Auth::id())
            ->findOrFail($order);

        abort_unless(in_array(strtolower($order->status), ['selesai', 'completed'], true), 403);

        if ($order->feedback) {
            return back()->with('error', 'Feedback untuk pesanan ini sudah pernah dikirim.');
        }

        Feedback::create([
            'star' => $request->validated('star'),
            'message' => $request->validated('message'),
            'Car_series_number' => $order->Car_series_number,
            'User_id' => Auth::id(),
            'Order_id' => $order->id,
        ]);

        return back()->with('success', 'Terima kasih atas ulasannya!');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return back()->with('success', 'Feedback berhasil dihapus.');
    }
}
