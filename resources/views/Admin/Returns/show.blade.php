@extends('layouts.Admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Ringkasan Pengembalian</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('returns.index') }}">Pengembalian Mobil</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="#">Ringkasan</a></li>
                </ul>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @php
                $payment      = $order->payments->first();
                $penalties    = $order->payments->flatMap->penalties;
                $totalPenalty = $penalties->sum('total_penalty');
                $basePrice    = ($payment?->total_price ?? 0) - $totalPenalty;
                if ($basePrice < 0) $basePrice = 0;
            @endphp

            <div class="row">
                {{-- Left Column --}}
                <div class="col-md-4">

                    {{-- Order Info --}}
                    <div class="card card-round mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                <i class="fa fa-receipt me-2 text-primary"></i>Info Pesanan
                            </h4>
                        </div>
                        <div class="card-body d-flex flex-column gap-3">
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">ID Pesanan</span>
                                <h6 class="mb-0 fw-bold">{{ $order->id }}</h6>
                            </div>
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">Pelanggan</span>
                                <h6 class="mb-0 fw-bold">{{ $order->name }}</h6>
                                <small class="text-muted">{{ $order->call_number }}</small>
                                @if ($order->email)
                                    <small class="d-block text-muted">{{ $order->email }}</small>
                                @endif
                            </div>
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">Mobil</span>
                                <h6 class="mb-0 fw-bold text-primary">{{ $order->car->name ?? '-' }}</h6>
                                <small class="text-muted">{{ $order->Car_series_number }}</small>
                            </div>
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">Periode Sewa</span>
                                <h6 class="mb-0">{{ $order->start_rent?->format('d M Y') ?? '-' }}</h6>
                                <small class="text-muted">s/d {{ $order->end_rent?->format('d M Y') ?? '-' }}</small>
                            </div>
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">Status Pesanan</span>
                                <span class="badge bg-primary">{{ ucfirst($order->status) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method & Status --}}
                    <div class="card card-round">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                <i class="fa fa-credit-card me-2 text-success"></i>Pembayaran
                            </h4>
                        </div>
                        <div class="card-body d-flex flex-column gap-3">
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">Metode</span>
                                <h6 class="mb-0 fw-bold">{{ $payment?->method ?? '—' }}</h6>
                            </div>
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">Status Pembayaran</span>
                                @php
                                    $payStatus  = $payment?->status ?? 'unknown';
                                    $statusClass = match($payStatus) {
                                        'paid'      => 'bg-success',
                                        'pending'   => 'bg-warning text-dark',
                                        'cancelled' => 'bg-danger',
                                        default     => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }} fs-6">{{ ucfirst($payStatus) }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right Column --}}
                <div class="col-md-8">

                    {{-- Penalties --}}
                    <div class="card card-round mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                <i class="fa fa-exclamation-triangle me-2 text-danger"></i>Denda yang Dikenakan
                            </h4>
                        </div>
                        <div class="card-body">
                            @if ($penalties->isEmpty())
                                <div class="text-center text-muted py-4">
                                    <i class="fa fa-check-circle fa-2x text-success mb-2 d-block"></i>
                                    Tidak ada denda — kondisi kendaraan baik.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Keterangan Denda</th>
                                                <th class="text-end">Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($penalties as $i => $penalty)
                                                <tr>
                                                    <td class="text-muted">{{ $i + 1 }}</td>
                                                    <td class="fw-bold">{{ $penalty->type }}</td>
                                                    <td class="text-end fw-bold text-danger">
                                                        Rp {{ number_format($penalty->total_penalty, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-light">
                                                <td colspan="2" class="fw-bold text-end">Total Denda</td>
                                                <td class="text-end fw-bold text-danger fs-5">
                                                    Rp {{ number_format($totalPenalty, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Payment Conclusion --}}
                    <div class="card card-round mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                <i class="fa fa-money-bill-wave me-2 text-success"></i>Kesimpulan Pembayaran
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="p-4 bg-light rounded-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Biaya Sewa</span>
                                    <span class="fw-bold">Rp {{ number_format($basePrice, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Total Denda</span>
                                    <span class="fw-bold {{ $totalPenalty > 0 ? 'text-danger' : 'text-muted' }}">
                                        Rp {{ number_format($totalPenalty, 0, ',', '.') }}
                                    </span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold fs-5">Grand Total</span>
                                    <span class="fw-bold fs-4 text-success">
                                        Rp {{ number_format($payment?->total_price ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action --}}
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('returns.index') }}" class="btn btn-black btn-border btn-round">
                            <i class="fa fa-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-round">
                            <i class="fa fa-eye me-1"></i> Lihat Detail Pesanan
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
