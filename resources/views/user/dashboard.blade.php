@extends('layouts.User.master')

@section('title', 'Dashboard User - Rentify')

@section('content')
    @php
        $statusTone = [
            'menunggu' => 'warning',
            'pending' => 'warning',
            'aktif' => 'success',
            'active' => 'success',
            'selesai' => 'info',
            'completed' => 'info',
            'dibatalkan' => 'danger',
            'cancelled' => 'danger',
        ];
    @endphp

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Dashboard User</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('user.dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.dashboard') }}">Dashboard</a>
                    </li>
                </ul>
            </div>

            <div class="card card-round rentify-hero-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <span class="badge bg-white/20 text-white mb-3 border border-white/30">User Portal</span>
                            <h2 class="fw-bold text-white mb-2">Selamat datang, {{ $user->name }}</h2>
                            <p class="text-white-50 mb-0">
                                Pantau pesanan, ketersediaan mobil, dan status autentikasi dokumen Anda dari satu dashboard.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                            <a href="{{ route('user.cars.index') }}" class="btn btn-white btn-round">
                                <i class="fas fa-car me-2"></i>Sewa Mobil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-xl-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Pesanan</p>
                                        <h4 class="card-title">{{ $totalOrders }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-car-side"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Rental Aktif</p>
                                        <h4 class="card-title">{{ $activeRentals }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-warning bubble-shadow-small">
                                        <i class="fas fa-hourglass-half"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Menunggu</p>
                                        <h4 class="card-title">{{ $pendingOrders }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-file-signature"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Dokumen Valid</p>
                                        <h4 class="card-title">{{ $verifiedDocuments }}/{{ $totalDocuments }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div>
                                    <div class="card-title">Pesanan Terbaru</div>
                                    <p class="card-category">Diambil langsung dari tabel order milik akun Anda.</p>
                                </div>
                                <div class="card-tools">
                                    <a href="{{ route('user.orders.index') }}" class="btn btn-label-info btn-round btn-sm">
                                        Lihat Semua
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Mobil</th>
                                            <th>Periode</th>
                                            <th>Status</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentOrders as $order)
                                            @php
                                                $days = $order->start_rent && $order->end_rent
                                                    ? $order->start_rent->diffInDays($order->end_rent) + 1
                                                    : 0;
                                                $total = $order->payments->sum('total_price') ?: (($order->car->price ?? 0) * $days);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <a href="{{ route('user.orders.show', $order->id) }}" class="fw-bold">
                                                        {{ $order->id }}
                                                    </a>
                                                </td>
                                                <td>{{ $order->car->name ?? 'Mobil tidak tersedia' }}</td>
                                                <td>
                                                    {{ optional($order->start_rent)->format('d M Y') }}
                                                    <small class="text-muted d-block">s/d {{ optional($order->end_rent)->format('d M Y') }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $statusTone[$order->status] ?? 'secondary' }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-end">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="rentify-empty">
                                                    <i class="fas fa-car fa-3x mb-3 text-muted"></i>
                                                    <h5 class="text-muted">Belum ada pesanan</h5>
                                                    <p class="text-muted">Mobil yang tersedia saat ini: {{ $availableCars }}</p>
                                                    <a href="{{ route('user.cars.index') }}" class="btn btn-primary btn-round btn-sm">
                                                        Lihat Mobil
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">Ringkasan Dokumen</div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                <div>
                                    <h6 class="fw-bold mb-1">Terverifikasi</h6>
                                    <p class="text-muted mb-0">Dokumen disetujui admin</p>
                                </div>
                                <span class="badge badge-success">{{ $verifiedDocuments }}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                <div>
                                    <h6 class="fw-bold mb-1">Menunggu</h6>
                                    <p class="text-muted mb-0">Sedang dicek admin</p>
                                </div>
                                <span class="badge badge-warning">{{ $pendingDocuments }}</span>
                            </div>
                            <div class="rentify-action-list d-grid gap-2">
                                <a href="{{ route('user.documents.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-file-signature me-2"></i>Kelola Dokumen
                                </a>
                                <a href="{{ route('user.cars.index') }}" class="btn btn-primary">
                                    <i class="fas fa-car me-2"></i>Lihat {{ $availableCars }} Mobil Tersedia
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">Status Akun</div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-lg me-3">
                                    <img src="{{ asset('assets/img/profile.jpg') }}" alt="Foto profil" class="avatar-img rounded-circle">
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $user->name }}</h5>
                                    <p class="text-muted mb-0">{{ $user->email }}</p>
                                    <span class="badge badge-{{ $verifiedDocuments > 0 ? 'success' : 'warning' }} mt-2">
                                        {{ $verifiedDocuments > 0 ? 'Dokumen valid' : 'Lengkapi dokumen' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
    <style>
        .rentify-hero-card {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            border: 0;
            margin-bottom: 24px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(249, 115, 22, 0.2);
        }

        .rentify-hero-card .card-body {
            padding: 32px;
        }
    </style>
@endsection
