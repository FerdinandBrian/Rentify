<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $dashboardService) {}

    public function index()
    {
        try {
            return view('Admin.dashboard', [
                'dashboard' => $this->dashboardService->getAdminDashboard(),
            ]);
        } catch (\Exception $e) {
            abort(500, 'Gagal memuat dashboard: ' . $e->getMessage());
        }
    }
}
