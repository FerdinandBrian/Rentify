<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center gap-2">
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
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <a href="{{ route('orders.index') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <p>Pesanan</p>
                    </a>
                </li>
                @if(Auth::user()->role_id === 2)
                <li class="nav-item {{ request()->routeIs('returns.*') ? 'active' : '' }}">
                    <a href="{{ route('returns.index') }}">
                        <i class="fas fa-undo-alt"></i>
                        <p>Pengembalian Mobil</p>
                    </a>
                </li>
                @endif
                <li class="nav-item {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.cars.index') }}">
                        <i class="fas fa-car"></i>
                        <p>Mobil</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                    <a href="{{ route('brands.index') }}">
                        <i class="fas fa-tags"></i>
                        <p>Merek</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('denda.*') ? 'active' : '' }}">
                    <a href="{{ route('denda.index') }}">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Denda</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.addons.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.addons.index') }}">
                        <i class="fas fa-plus-circle"></i>
                        <p>AddOn</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('documents.*') || request()->routeIs('document.*') ? 'active' : '' }}">
                    <a href="{{ route('documents.index') }}">
                        <i class="fas fa-file-alt"></i>
                        <p>Dokumen</p>
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
                <li class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <a href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-cog"></i>
                        <p>Profil</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('admin-sidebar-logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="admin-sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
