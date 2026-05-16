@php
    $userNavMetrics = $userNavMetrics ?? [
        'pending_orders' => 0,
        'active_orders' => 0,
        'pending_documents' => 0,
        'approved_documents' => 0,
        'available_cars' => 0,
    ];
@endphp

<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('user.dashboard') }}" class="logo d-flex align-items-center gap-2">
                <div class="rounded-3 bg-gradient-to-br bg-primary d-flex align-items-center justify-center font-bold text-white shadow-sm" style="width: 32px; height: 32px; font-size: 18px; line-height: 32px; text-align: center;">R</div>
                <span class="fw-bold fs-4 text-white">Rentify</span>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-white text-section">Menu User</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('user.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('user.cars.*') ? 'active' : '' }}">
                    <a href="{{ route('user.cars.index') }}">
                        <i class="fas fa-car"></i>
                        <p>Mobil</p>
                        <span class="badge badge-count">{{ $userNavMetrics['available_cars'] }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('user.orders.*') ? 'active' : '' }}">
                    <a href="{{ route('user.orders.index') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <p>Pesanan Saya</p>
                        @if($userNavMetrics['active_orders'] > 0)
                            <span class="badge badge-success">{{ $userNavMetrics['active_orders'] }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('user.documents.*') ? 'active' : '' }}">
                    <a href="{{ route('user.documents.index') }}">
                        <i class="fas fa-file-signature"></i>
                        <p>Autentikasi Dokumen</p>
                        @if($userNavMetrics['pending_documents'] > 0)
                            <span class="badge badge-warning">{{ $userNavMetrics['pending_documents'] }}</span>
                        @endif
                    </a>
                </li>
            </ul>

            <ul class="nav nav-secondary mt-3">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Akun</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
                    <a href="{{ route('user.profile.index') }}">
                        <i class="fas fa-user-cog"></i>
                        <p>Profil</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('user-sidebar-logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="user-sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
