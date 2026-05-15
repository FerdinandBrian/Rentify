@extends('layouts.Admin.master')

@section('content')
    @php
        $badgeMap = [
            'menunggu' => 'warning',
            'pending' => 'warning',
            'aktif' => 'success',
            'active' => 'success',
            'berjalan' => 'success',
            'selesai' => 'primary',
            'completed' => 'primary',
            'dibatalkan' => 'danger',
            'cancelled' => 'danger',
            'canceled' => 'danger',
        ];
    @endphp

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Pesanan</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('orders.index') }}">Tampilan Pesanan</a></li>
                </ul>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <h4 class="card-title">Daftar Pesanan Rental</h4>
                        <form action="{{ route('orders.index') }}" method="GET" class="ms-auto d-flex gap-2">
                            <select name="status" class="form-select">
                                <option value="semua">Semua Status</option>
                                @foreach (['menunggu', 'aktif', 'selesai', 'dibatalkan'] as $status)
                                    <option value="{{ $status }}" @selected(request('status') === $status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Pelanggan</th>
                                    <th>ID Mobil</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th>Total Harga</th>
                                    <th class="text-end" style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    @php
                                        $statusKey = strtolower($order->status);
                                        $badge = $badgeMap[$statusKey] ?? 'secondary';
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $order->name }}</span>
                                            <small class="d-block text-muted">{{ $order->email ?? $order->call_number }}</small>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $order->Car_series_number }}</span>
                                            <small class="d-block text-muted">{{ $order->car->name ?? 'Mobil tidak tersedia' }}</small>
                                        </td>
                                        <td>
                                            {{ $order->start_rent?->format('d M Y') ?? '-' }}
                                            <small class="d-block text-muted">sampai {{ $order->end_rent?->format('d M Y') ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $badge }}">{{ ucfirst($order->status) }}</span>
                                        </td>
                                        <td>Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-end">
                                            <div class="form-button-action justify-content-end">
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-link btn-info btn-lg"
                                                    data-bs-toggle="tooltip" title="Detail">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if(auth()->user()->role->name == 'admin')
                                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-link btn-primary btn-lg"
                                                    data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-link btn-danger" type="submit"
                                                        data-bs-toggle="tooltip" title="Hapus"
                                                        onclick="return confirm('Hapus pesanan ini?')">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">Belum ada pesanan untuk filter ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }}
                            dari {{ $orders->total() }} pesanan
                        </small>
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
