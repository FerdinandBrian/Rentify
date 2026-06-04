<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with(['car', 'user'])->get();
        return view('feedbacks.index', compact('feedbacks'));
    }

    public function store(StoreFeedbackRequest $request)
    {
        Feedback::create($request->validated());
        return back()->with('success', 'Terima kasih atas ulasannya!');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return back()->with('success', 'Feedback berhasil dihapus.');
    }
}
