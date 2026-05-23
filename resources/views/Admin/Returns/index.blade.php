@extends('layouts.Admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Pengembalian Mobil</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('returns.index') }}">Pengembalian Mobil</a></li>
                </ul>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Active Rentals Section --}}
            <div class="card card-round">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h4 class="card-title mb-0">Rental Aktif — Perlu Diproses</h4>
                            <small class="text-muted">Daftar mobil yang sedang disewa dan menunggu pengembalian</small>
                        </div>
                        <span class="badge bg-success ms-3 fs-6">{{ $activeOrders->total() }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Mobil</th>
                                    <th>Periode Sewa</th>
                                    <th>Total Bayar</th>
                                    <th class="text-end" style="width: 180px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activeOrders as $order)
                                    @php
                                        $isOverdue = $order->end_rent && now()->isAfter($order->end_rent);
                                    @endphp
                                    <tr class="{{ $isOverdue ? 'table-warning' : '' }}">
                                        <td class="fw-bold">
                                            {{ $order->id }}
                                            @if ($isOverdue)
                                                <span class="badge bg-danger ms-1">Telat</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $order->name }}</span>
                                            <small class="d-block text-muted">{{ $order->call_number }}</small>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $order->car->name ?? '-' }}</span>
                                            <small class="d-block text-muted">{{ $order->Car_series_number }}</small>
                                        </td>
                                        <td>
                                            {{ $order->start_rent?->format('d M Y') ?? '-' }}
                                            <small class="d-block text-muted">s/d {{ $order->end_rent?->format('d M Y') ?? '-' }}</small>
                                        </td>
                                        <td class="fw-bold text-success">
                                            Rp {{ number_format($order->payments->sum('total_price'), 0, ',', '.') }}
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('returns.create', $order->id) }}"
                                               class="btn btn-primary btn-sm btn-round">
                                                <i class="fa fa-car-crash me-1"></i> Proses Pengembalian
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="fa fa-check-circle fa-2x mb-3 d-block text-success"></i>
                                            Tidak ada rental aktif saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $activeOrders->firstItem() ?? 0 }} - {{ $activeOrders->lastItem() ?? 0 }}
                            dari {{ $activeOrders->total() }} rental aktif
                        </small>
                        {{ $activeOrders->appends(['completed_page' => $completedOrders->currentPage()])->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>

            {{-- Completed Returns History --}}
            <div class="card card-round mt-4">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h4 class="card-title mb-0">Riwayat Pengembalian</h4>
                            <small class="text-muted">Pesanan yang telah selesai dan sudah diproses</small>
                        </div>
                        <span class="badge bg-primary ms-3 fs-6">{{ $completedOrders->total() }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Mobil</th>
                                    <th>Periode Sewa</th>
                                    <th>Denda</th>
                                    <th>Status Bayar</th>
                                    <th class="text-end" style="width: 120px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($completedOrders as $order)
                                    @php
                                        $payment = $order->payments->first();
                                        $totalPenalties = $order->payments->flatMap->penalties->sum('total_penalty');
                                    @endphp
                                    <tr>
                                        <td class="fw-bold">{{ $order->id }}</td>
                                        <td>
                                            <span class="fw-bold">{{ $order->name }}</span>
                                            <small class="d-block text-muted">{{ $order->call_number }}</small>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $order->car->name ?? '-' }}</span>
                                            <small class="d-block text-muted">{{ $order->Car_series_number }}</small>
                                        </td>
                                        <td>
                                            {{ $order->start_rent?->format('d M Y') ?? '-' }}
                                            <small class="d-block text-muted">s/d {{ $order->end_rent?->format('d M Y') ?? '-' }}</small>
                                        </td>
                                        <td>
                                            @if ($totalPenalties > 0)
                                                <span class="text-danger fw-bold">Rp {{ number_format($totalPenalties, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $payStatus = $payment?->status ?? 'unknown';
                                                $statusClass = match($payStatus) {
                                                    'paid' => 'bg-success',
                                                    'pending' => 'bg-warning text-dark',
                                                    'cancelled' => 'bg-danger',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ ucfirst($payStatus) }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('returns.show', $order->id) }}"
                                               class="btn btn-link btn-info btn-lg"
                                               data-bs-toggle="tooltip" title="Lihat Ringkasan">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-5">
                                            Belum ada riwayat pengembalian.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $completedOrders->firstItem() ?? 0 }} - {{ $completedOrders->lastItem() ?? 0 }}
                            dari {{ $completedOrders->total() }} pengembalian
                        </small>
                        {{ $completedOrders->appends(['active_page' => $activeOrders->currentPage()])->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
