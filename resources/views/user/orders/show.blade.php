@extends('layouts.User.master')

@section('title', 'Detail Pesanan - Rentify')

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
        $days = $order->start_rent && $order->end_rent ? $order->start_rent->diffInDays($order->end_rent) + 1 : 0;
        $paymentTotal = $order->payments->sum('total_price');
        $total = $paymentTotal ?: (($order->car->price ?? 0) * $days);
        $latestPayment = $order->payments->last();
        $canCancel = in_array($order->status, ['menunggu', 'pending'], true);
    @endphp

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Detail Pesanan</h4>
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
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <span>{{ $order->id }}</span>
                    </li>
                </ul>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div>
                                    <div class="card-title">Ringkasan Pesanan</div>
                                    <p class="card-category">ID {{ $order->id }}</p>
                                </div>
                                <div class="card-tools">
                                    <span class="badge badge-{{ $statusTone[$order->status] ?? 'secondary' }} badge-lg">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-row">
                                        <span>Pemesan</span>
                                        <strong>{{ $order->name }}</strong>
                                    </div>
                                    <div class="info-row">
                                        <span>Email</span>
                                        <strong>{{ $order->email ?? '-' }}</strong>
                                    </div>
                                    <div class="info-row">
                                        <span>No. Telepon</span>
                                        <strong>{{ $order->call_number }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-row">
                                        <span>Tanggal Mulai</span>
                                        <strong>{{ optional($order->start_rent)->format('d M Y H:i') }}</strong>
                                    </div>
                                    <div class="info-row">
                                        <span>Tanggal Selesai</span>
                                        <strong>{{ optional($order->end_rent)->format('d M Y H:i') }}</strong>
                                    </div>
                                    <div class="info-row">
                                        <span>Durasi</span>
                                        <strong>{{ $days }} hari</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-round mt-4">
                        <div class="card-header">
                            <div class="card-title">Mobil yang Dipesan</div>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <img src="{{ asset('assets/img/examples/product2.jpg') }}" alt="{{ $order->car->name ?? 'Mobil' }}"
                                        class="img-fluid rounded order-car-img">
                                </div>
                                <div class="col-md-8">
                                    <h5>{{ $order->car->name ?? 'Mobil tidak tersedia' }}</h5>
                                    <p class="text-muted mb-3">
                                        <i class="fas fa-tag me-2"></i>{{ $order->car->brand->name ?? '-' }}
                                        <span class="mx-2">-</span>
                                        <i class="fas fa-car me-2"></i>{{ $order->car->type ?? '-' }}
                                        <span class="mx-2">-</span>
                                        <i class="fas fa-id-card me-2"></i>{{ $order->Car_series_number }}
                                    </p>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <small class="text-muted">Harga per hari</small>
                                            <p class="fw-bold">Rp {{ number_format($order->car->price ?? 0, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <small class="text-muted">Status mobil</small>
                                            <p class="fw-bold">{{ ucfirst($order->car->status ?? '-') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-round mt-4">
                        <div class="card-header">
                            <div class="card-title">Pembayaran</div>
                        </div>
                        <div class="card-body">
                            @if($order->payments->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Metode</th>
                                                <th>Status</th>
                                                <th class="text-end">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->payments as $payment)
                                                <tr>
                                                    <td>{{ $payment->method }}</td>
                                                    <td><span class="badge badge-info">{{ ucfirst($payment->status) }}</span></td>
                                                    <td class="text-end">Rp {{ number_format($payment->total_price ?? 0, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Belum ada data payment untuk pesanan ini. Estimasi biaya tetap dihitung dari harga mobil dan durasi sewa.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">Ringkasan Biaya</div>
                        </div>
                        <div class="card-body">
                            <div class="summary-box">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Harga per hari</span>
                                    <strong>Rp {{ number_format($order->car->price ?? 0, 0, ',', '.') }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Jumlah hari</span>
                                    <strong>{{ $days }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Payment tercatat</span>
                                    <strong>Rp {{ number_format($paymentTotal, 0, ',', '.') }}</strong>
                                </div>
                                <div class="d-flex justify-content-between total-row">
                                    <span>Total</span>
                                    <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                                </div>
                            </div>

                            <div class="mt-3">
                                <small class="text-muted d-block">Status pembayaran</small>
                                <span class="badge badge-{{ ($latestPayment && $latestPayment->status === 'paid') ? 'success' : 'warning' }}">
                                    {{ $latestPayment ? ucfirst($latestPayment->status) : 'Belum ada payment' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card card-round mt-4">
                        <div class="card-header">
                            <div class="card-title">Aksi Pesanan</div>
                        </div>
                        <div class="card-body rentify-action-list d-grid gap-2">
                            <a href="{{ route('user.orders.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Pesanan
                            </a>
                            @if($canCancel)
                                <form method="POST" action="{{ route('user.orders.cancel', $order->id) }}"
                                    onsubmit="return confirm('Batalkan pesanan ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-times me-2"></i>Batalkan Pesanan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="card card-round mt-4">
                        <div class="card-header">
                            <div class="card-title">Status</div>
                        </div>
                        <div class="card-body">
                            <div class="timeline-mini">
                                <div class="timeline-mini-item active">
                                    <span></span>
                                    <div>
                                        <strong>Pesanan dibuat</strong>
                                        <p class="text-muted mb-0">Tersimpan di database order.</p>
                                    </div>
                                </div>
                                <div class="timeline-mini-item {{ in_array($order->status, ['aktif', 'selesai', 'active', 'completed'], true) ? 'active' : '' }}">
                                    <span></span>
                                    <div>
                                        <strong>Dikonfirmasi</strong>
                                        <p class="text-muted mb-0">Menunggu validasi admin.</p>
                                    </div>
                                </div>
                                <div class="timeline-mini-item {{ in_array($order->status, ['selesai', 'completed'], true) ? 'active' : '' }}">
                                    <span></span>
                                    <div>
                                        <strong>Selesai</strong>
                                        <p class="text-muted mb-0">Rental selesai.</p>
                                    </div>
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
        .badge-lg {
            font-size: .95rem;
            padding: .45rem .85rem;
        }

        .info-row {
            padding: 12px 0;
            border-bottom: 1px solid #eef1f5;
        }

        .info-row span,
        .info-row strong {
            display: block;
        }

        .info-row span {
            color: #6c757d;
            font-size: .8rem;
            margin-bottom: 4px;
        }

        .order-car-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .summary-box {
            padding: 16px;
            border-radius: 8px;
            background: #f8fafc;
        }

        .total-row {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #e7ebf0;
            color: #1572e8;
        }

        .timeline-mini {
            display: grid;
            gap: 18px;
        }

        .timeline-mini-item {
            display: flex;
            gap: 12px;
            opacity: .55;
        }

        .timeline-mini-item.active {
            opacity: 1;
        }

        .timeline-mini-item > span {
            width: 12px;
            height: 12px;
            margin-top: 4px;
            border-radius: 50%;
            background: #ced4da;
            flex: 0 0 auto;
        }

        .timeline-mini-item.active > span {
            background: #1572e8;
        }
    </style>
@endsection
