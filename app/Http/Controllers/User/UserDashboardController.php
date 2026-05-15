<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserDashboardService;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function __construct(private readonly UserDashboardService $dashboardService) {}

    public function index()
    {
        return view('user.dashboard', $this->dashboardService->dataFor(Auth::user()));
    }
}
