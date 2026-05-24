@extends('layouts.User.master')

@section('title', 'Pesanan Saya - Rentify')

@section('content')
    @php
        $tabs = [
            '' => 'Semua',
            'menunggu' => 'Menunggu',
            'aktif' => 'Aktif',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];
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
                <h4 class="page-title">Menu Pesanan</h4>
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
                        <a href="{{ route('user.orders.index') }}">Pesanan Saya</a>
                    </li>
                </ul>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div>
                            <div class="card-title">Riwayat Pemesanan</div>
                            <p class="card-category">Data berasal dari tabel order dan payment akun Anda.</p>
                        </div>
                        <div class="card-tools">
                            <a href="{{ route('user.cars.index') }}" class="btn btn-primary btn-round btn-sm">
                                <i class="fas fa-plus me-2"></i>Pesan Mobil
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4 overflow-auto">
                        <ul class="nav nav-pills rentify-order-tabs flex-nowrap" role="tablist">
                            @foreach($tabs as $status => $label)
                                <li class="nav-item">
                                    <a class="nav-link {{ request('status', '') === $status ? 'active' : '' }}"
                                        href="{{ $status === '' ? route('user.orders.index') : route('user.orders.index', ['status' => $status]) }}">
                                        {{ $label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Mobil</th>
                                    <th>Tanggal Sewa</th>
                                    <th>Durasi</th>
                                    <th>Status</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
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
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-light rounded-circle me-3">
                                                    <i class="fas fa-car text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $order->car->name ?? 'Mobil tidak tersedia' }}</h6>
                                                    <small class="text-muted">{{ $order->car->brand->name ?? '-' }} - {{ $order->Car_series_number }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ optional($order->start_rent)->format('d M Y') }}
                                            <small class="text-muted d-block">s/d {{ optional($order->end_rent)->format('d M Y') }}</small>
                                        </td>
                                        <td>{{ $days }} hari</td>
                                        <td>
                                            <span class="badge badge-{{ $statusTone[$order->status] ?? 'secondary' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="{{ route('user.orders.show', $order->id) }}"
                                                    class="btn btn-sm btn-primary" title="Lihat detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(in_array($order->status, ['menunggu', 'pending'], true))
                                                    <form method="POST" action="{{ route('user.orders.cancel', $order->id) }}"
                                                        onsubmit="return confirm('Batalkan pesanan ini?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Batalkan">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="rentify-empty">
                                                <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                                                <h5 class="text-muted">Belum ada pesanan</h5>
                                                <p class="text-muted">Pilih mobil tersedia lalu buat pesanan pertama Anda.</p>
                                                <a href="{{ route('user.cars.index') }}" class="btn btn-primary btn-round">
                                                    Lihat Mobil
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($orders->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
    <style>
        .rentify-order-tabs {
            border-bottom: 1px solid #e9ecef;
            gap: 8px;
            margin-bottom: 0;
            min-width: max-content;
            padding-bottom: 10px;
        }

        .rentify-order-tabs .nav-link {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 10px !important;
            color: #9a3412 !important;
            font-weight: 700;
            min-width: 108px;
            padding: 10px 18px;
            text-align: center;
            white-space: nowrap;
        }

        .rentify-order-tabs .nav-link.active {
            background: #f97316 !important;
            border-color: #f97316 !important;
            box-shadow: 0 10px 20px rgba(249, 115, 22, .16);
            color: #0f172a !important;
        }

        .rentify-order-tabs .nav-link:hover {
            background: #ffedd5;
            border-color: #fdba74;
            color: #7c2d12 !important;
        }

        .avatar-sm {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-group form {
            display: inline-flex;
        }
    </style>
@endsection
