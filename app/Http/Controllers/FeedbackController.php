<?php


namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Car;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with(['car', 'user'])->get();
        return view('feedbacks.index', compact('feedbacks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'star'              => 'required|integer|min:1|max:5',
            'message'           => 'required|string',
            'Car_series_number' => 'required|exists:car,series_number',
            'User_id'           => 'required|exists:users,id',
        ]);

        Feedback::create($validated);
        return back()->with('success', 'Terima kasih atas ulasannya!');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return back()->with('success', 'Feedback berhasil dihapus.');
    }
}
