<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(StoreFeedbackRequest $request, string $seriesNumber)
    {
        $userId = Auth::id();

        // Check if user already submitted feedback for this car
        $existing = Feedback::where('Car_series_number', $seriesNumber)
            ->where('User_id', $userId)
            ->exists();

        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk mobil ini.');
        }

        Feedback::create([
            'star' => $request->validated('star'),
            'message' => $request->validated('message'),
            'Car_series_number' => $seriesNumber,
            'User_id' => $userId,
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
