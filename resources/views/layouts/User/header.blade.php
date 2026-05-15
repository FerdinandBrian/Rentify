@php
    $userNavMetrics = $userNavMetrics ?? [
        'pending_orders' => 0,
        'active_orders' => 0,
        'pending_documents' => 0,
        'approved_documents' => 0,
        'available_cars' => 0,
    ];

    $notificationTotal = $userNavMetrics['pending_orders'] + $userNavMetrics['pending_documents'];
@endphp

<div class="main-header">
    <div class="main-header-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('user.dashboard') }}" class="logo">
                <span class="text-white fw-bold fs-4">Rentify</span>
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

    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <div class="navbar-header-left d-none d-lg-flex flex-column">
                <span class="fw-semibold">Portal Penyewa</span>
                <small class="text-muted">Kelola mobil, pesanan, dan dokumen Anda.</small>
            </div>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        @if($notificationTotal > 0)
                            <span class="notification">{{ $notificationTotal }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn dropdown-menu-end" aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">
                                Ringkasan akun dari database
                            </div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                    <a href="{{ route('user.orders', ['status' => 'menunggu']) }}">
                                        <div class="notif-icon notif-warning">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="notif-content">
                                            <span class="block">{{ $userNavMetrics['pending_orders'] }} pesanan menunggu</span>
                                            <span class="time">Perlu konfirmasi admin</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('user.orders', ['status' => 'aktif']) }}">
                                        <div class="notif-icon notif-success">
                                            <i class="fas fa-car-side"></i>
                                        </div>
                                        <div class="notif-content">
                                            <span class="block">{{ $userNavMetrics['active_orders'] }} rental aktif</span>
                                            <span class="time">Sedang berjalan</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('user.documents') }}">
                                        <div class="notif-icon notif-info">
                                            <i class="fas fa-file-signature"></i>
                                        </div>
                                        <div class="notif-content">
                                            <span class="block">{{ $userNavMetrics['pending_documents'] }} dokumen menunggu</span>
                                            <span class="time">{{ $userNavMetrics['approved_documents'] }} dokumen disetujui</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('user.cars') }}">
                                        <div class="notif-icon notif-primary">
                                            <i class="fas fa-car"></i>
                                        </div>
                                        <div class="notif-content">
                                            <span class="block">{{ $userNavMetrics['available_cars'] }} mobil tersedia</span>
                                            <span class="time">Siap dipesan</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="quickActionsDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-layer-group"></i>
                    </a>
                    <div class="dropdown-menu quick-actions animated fadeIn dropdown-menu-end"
                        aria-labelledby="quickActionsDropdown">
                        <div class="quick-actions-header">
                            <span class="title mb-1">Aksi Cepat</span>
                            <span class="subtitle op-7">Shortcut user</span>
                        </div>
                        <div class="quick-actions-scroll scrollbar-outer">
                            <div class="quick-actions-items">
                                <div class="row m-0">
                                    <a class="col-6 p-0" href="{{ route('user.cars') }}">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-primary rounded-circle">
                                                <i class="fas fa-car"></i>
                                            </div>
                                            <span class="text">Mobil</span>
                                        </div>
                                    </a>
                                    <a class="col-6 p-0" href="{{ route('user.orders') }}">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-success rounded-circle">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                            <span class="text">Pesanan</span>
                                        </div>
                                    </a>
                                    <a class="col-6 p-0" href="{{ route('user.documents') }}">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-warning rounded-circle">
                                                <i class="fas fa-file-upload"></i>
                                            </div>
                                            <span class="text">Dokumen</span>
                                        </div>
                                    </a>
                                    <a class="col-6 p-0" href="{{ route('user.profile.edit') }}">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-info rounded-circle">
                                                <i class="fas fa-user-cog"></i>
                                            </div>
                                            <span class="text">Profil</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                        aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{ asset('assets/img/profile.jpg') }}" alt="Foto profil"
                                class="avatar-img rounded-circle" />
                        </div>
                        <span class="profile-username">
                            <span class="op-7">Hi,</span>
                            <span class="fw-bold">{{ Auth::user()->name }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn dropdown-menu-end">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <img src="{{ asset('assets/img/profile.jpg') }}" alt="Foto profil"
                                            class="avatar-img rounded" />
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ Auth::user()->name }}</h4>
                                        <p class="text-muted">{{ Auth::user()->email }}</p>
                                        <a href="{{ route('user.profile.edit') }}" class="btn btn-xs btn-secondary btn-sm">
                                            Lihat Profil
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('user.orders') }}">Pesanan Saya</a>
                                <a class="dropdown-item" href="{{ route('user.documents') }}">Dokumen Saya</a>
                                <a class="dropdown-item" href="{{ route('user.profile.edit') }}">Pengaturan Akun</a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
