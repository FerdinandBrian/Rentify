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
            <a href="{{ route('user.dashboard') }}" class="logo d-flex align-items-center gap-2">
                <div class="rounded-3 bg-gradient-to-br bg-primary d-flex align-items-center justify-content-center font-bold text-white shadow-sm" style="width: 32px; height: 32px; font-size: 18px; line-height: 32px; text-align: center;">R</div>
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

    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <div class="navbar-header-left d-none d-lg-flex flex-column">
                <span class="fw-semibold">Portal Penyewa</span>
                <small class="text-muted">Kelola mobil, pesanan, dan dokumen Anda.</small>
            </div>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
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
                                    <a class="col-6 p-0" href="{{ route('user.cars.index') }}">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-primary rounded-circle">
                                                <i class="fas fa-car"></i>
                                            </div>
                                            <span class="text">Mobil</span>
                                        </div>
                                    </a>
                                    <a class="col-6 p-0" href="{{ route('user.orders.index') }}">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-success rounded-circle">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div>
                                            <span class="text">Pesanan</span>
                                        </div>
                                    </a>
                                    <a class="col-6 p-0" href="{{ route('user.documents.index') }}">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-warning rounded-circle">
                                                <i class="fas fa-file-upload"></i>
                                            </div>
                                            <span class="text">Dokumen</span>
                                        </div>
                                    </a>
                                    <a class="col-6 p-0" href="{{ route('user.profile.index') }}">
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
                        <span class="profile-username text-white">
                            <span class="op-7">Hi,</span>
                            <span class="fw-bold">{{ Auth::user()->name }}</span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
