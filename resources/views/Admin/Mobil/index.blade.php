@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Mobil</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><span>Manajemen Mobil</span></li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-end gap-3">
                    <h4 class="card-title mb-0 me-auto">Daftar Mobil</h4>

                    <form method="GET" action="{{ route('admin.cars.index') }}" class="car-filter-form">
                        <select name="brand_id" class="form-select form-select-sm" aria-label="Filter merek">
                            <option value="">Semua Merek</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="type" class="form-select form-select-sm" aria-label="Filter tipe">
                            <option value="">Semua Tipe</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary btn-sm btn-round">
                            <i class="fa fa-filter"></i>
                        </button>

                        @if(request()->filled('brand_id') || request()->filled('type'))
                            <a href="{{ route('admin.cars.index') }}" class="btn btn-light btn-sm btn-round" title="Reset filter">
                                <i class="fa fa-undo"></i>
                            </a>
                        @endif
                    </form>

                    @if(auth()->user()->role->name == 'admin')
                        <a href="{{ route('admin.cars.create') }}" class="btn btn-primary btn-round">
                            <i class="fa fa-plus"></i>
                            Tambah Mobil
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Plat Nomor</th>
                                <th>Nama</th>
                                <th>Merek</th>
                                <th>Harga/Hari</th>
                                <th>Tipe</th>
                                <th>Listrik</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cars as $car)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset($car->primary_image_path) }}" alt="{{ $car->name }}" class="car-thumb">
                                    </td>
                                    <td class="fw-bold">{{ $car->series_number }}</td>
                                    <td>{{ $car->name }}</td>
                                    <td>{{ $car->brand->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($car->price, 0, ',', '.') }}</td>
                                    <td>{{ $car->type }}</td>
                                    <td class="text-center">
                                        @if($car->is_electric)
                                            <span class="badge bg-info"><i class="fa fa-bolt text-warning"></i> EV</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $availableStatuses = ['available', 'tersedia'];
                                            $isAvailable = in_array(strtolower($car->status), $availableStatuses, true);
                                        @endphp
                                        <span class="badge car-status-badge {{ $isAvailable ? 'car-status-available' : 'car-status-unavailable' }}">
                                            {{ $car->status }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="form-button-action justify-content-end">
                                            <a href="{{ route('admin.cars.show', $car->series_number) }}"
                                                class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if(auth()->user()->role->name == 'admin')
                                            <a href="{{ route('admin.cars.edit', $car->series_number) }}"
                                                class="btn btn-primary btn-sm admin-action-btn" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.cars.destroy', $car->series_number) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link btn-danger"
                                                    data-bs-toggle="tooltip" title="Hapus"
                                                    onclick="return confirm('Yakin hapus mobil ini?')">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-5">Belum ada data mobil.</td>
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

@section('extraCSS')
<style>
    .car-thumb {
        width: 72px;
        height: 48px;
        object-fit: cover;
        border-radius: 6px;
        background: #f1f3f5;
    }

    .car-filter-form {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .car-filter-form .form-select {
        width: 150px;
    }

    .badge.car-status-badge {
        color: #fff;
        min-width: 78px;
        padding: 7px 10px;
    }

    .badge.car-status-badge.car-status-available {
        background: #31ce36;
        color: #fff !important;
    }

    .badge.car-status-badge.car-status-unavailable {
        background: #f25961;
        color: #fff !important;
    }

    .admin-action-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        padding: 0;
    }

    .admin-action-btn i {
        color: #fff;
    }

    @media (max-width: 768px) {
        .car-filter-form,
        .car-filter-form .form-select,
        .card-header .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('extraJS')
@endsection
