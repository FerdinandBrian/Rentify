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
                <div class="col-md-6">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">Data Pelanggan</div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-3">
                                <div>
                                    <span class="text-muted">Nama</span>
                                    <h5 class="mb-0">{{ $order->name }}</h5>
                                </div>
                                <div>
                                    <span class="text-muted">Email</span>
                                    <h5 class="mb-0">{{ $order->email ?? '-' }}</h5>
                                </div>
                                <div>
                                    <span class="text-muted">Nomor Telepon</span>
                                    <h5 class="mb-0">{{ $order->call_number }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">Data Rental</div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-3">
                                <div>
                                    <span class="text-muted">Mobil</span>
                                    <h5 class="mb-0">{{ $order->car->name ?? 'Mobil tidak tersedia' }}</h5>
                                    <small class="text-muted">{{ $order->Car_series_number }}</small>
                                </div>
                                <div>
                                    <span class="text-muted">Periode</span>
                                    <h5 class="mb-0">{{ $order->start_rent?->format('d M Y H:i') ?? '-' }} - {{ $order->end_rent?->format('d M Y H:i') ?? '-' }}</h5>
                                </div>
                                <div>
                                    <span class="text-muted">Status</span>
                                    <h5 class="mb-0">{{ ucfirst($order->status) }}</h5>
                                </div>
                                <div>
                                    <span class="text-muted">Total Pembayaran</span>
                                    <h5 class="mb-0">Rp {{ number_format($order->payments->sum('total_price'), 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-action text-end">
                            <a href="{{ route('orders.index') }}" class="btn btn-danger">Kembali</a>
                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">Edit Pesanan</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Pembayaran</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID Payment</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order->payments as $payment)
                                    <tr>
                                        <td>#{{ $payment->id }}</td>
                                        <td>{{ $payment->method ?? '-' }}</td>
                                        <td>{{ ucfirst($payment->status) }}</td>
                                        <td>Rp {{ number_format($payment->total_price ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada pembayaran.</td>
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
