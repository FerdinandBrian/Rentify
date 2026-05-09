@extends('layouts.Admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Detail Pesanan</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('orders.index') }}">Pesanan</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="#">Detail</a></li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card card-round">
                        <div class="card-header">
                            <h4 class="card-title">Data Pelanggan</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-3">
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase">Nama</span>
                                    <h5 class="mb-0 fw-bold">{{ $order->name }}</h5>
                                </div>
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase">Email</span>
                                    <h5 class="mb-0">{{ $order->email ?? '-' }}</h5>
                                </div>
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase">Nomor Telepon</span>
                                    <h5 class="mb-0">{{ $order->call_number }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-round">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title">Data Rental</h4>
                            <div class="ms-auto">
                                @php
                                    $badgeClass = [
                                        'menunggu' => 'bg-warning text-dark',
                                        'aktif' => 'bg-success',
                                        'selesai' => 'bg-primary',
                                        'dibatalkan' => 'bg-danger',
                                    ][strtolower($order->status)] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <span class="text-muted small fw-bold text-uppercase">Mobil</span>
                                    <h5 class="mb-0 fw-bold text-primary">{{ $order->car->name ?? 'Mobil tidak tersedia' }}</h5>
                                    <small class="text-muted">{{ $order->Car_series_number }}</small>
                                </div>
                                <div class="col-md-6 mb-3 text-md-end">
                                    <span class="text-muted small fw-bold text-uppercase">Total Pembayaran</span>
                                    <h4 class="mb-0 fw-bold text-success">Rp {{ number_format($order->payments->sum('total_price'), 0, ',', '.') }}</h4>
                                </div>
                                <div class="col-md-12">
                                    <span class="text-muted small fw-bold text-uppercase">Periode Sewa</span>
                                    <h5 class="mb-0">
                                        <i class="fa fa-calendar-alt text-muted me-2"></i>
                                        {{ $order->start_rent?->format('d M Y H:i') ?? '-' }} 
                                        <i class="fa fa-arrow-right mx-2 text-muted"></i>
                                        {{ $order->end_rent?->format('d M Y H:i') ?? '-' }}
                                    </h5>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top d-flex gap-2">
                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-round">
                                    <i class="fa fa-edit"></i> Edit Pesanan
                                </a>
                                <a href="{{ route('orders.index') }}" class="btn btn-black btn-border btn-round">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Riwayat Pembayaran</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID Pembayaran</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order->payments as $payment)
                                    <tr>
                                        <td class="fw-bold">#{{ $payment->id }}</td>
                                        <td>{{ $payment->method ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $payment->status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end fw-bold">Rp {{ number_format($payment->total_price ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">Belum ada data pembayaran untuk pesanan ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
