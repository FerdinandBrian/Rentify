@extends('layouts.User.master')

@section('title', 'Daftar Mobil - Rentify')

@section('content')
    @php
        $selectedBrand = $brands->firstWhere('id', (int) request('brand'));
    @endphp

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Menu Mobil</h4>
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
                        <a href="{{ route('user.cars.index') }}">Mobil</a>
                    </li>
                </ul>
            </div>

            <div class="card card-round">
                <div class="card-header">
                    <form method="GET" action="{{ route('user.cars.index') }}">
                        <div class="row g-2 align-items-end">
                            <div class="col-lg-4">
                                <label for="search" class="form-label">Cari Mobil</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" name="search" id="search" class="form-control"
                                        value="{{ request('search') }}" placeholder="Nama mobil atau plat nomor">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-2">
                                <label for="brand" class="form-label">Merek</label>
                                <select name="brand" id="brand" class="form-select">
                                    <option value="">Semua merek</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-lg-2">
                                <label for="type" class="form-label">Tipe</label>
                                <select name="type" id="type" class="form-select">
                                    <option value="">Semua tipe</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-lg-2">
                                <label for="start_date" class="form-label">Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ request('start_date') }}" min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-4 col-lg-2">
                                <label for="end_date" class="form-label">Selesai</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ request('end_date') }}" min="{{ request('start_date', date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-4 col-lg-12 d-flex gap-2 justify-content-lg-end">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-filter me-1"></i>Filter
                                </button>
                                <a href="{{ route('user.cars.index') }}" class="btn btn-icon btn-light" title="Reset filter">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    @if(request()->filled('brand') || request()->filled('type') || request()->filled('search') || request()->filled('start_date') || request()->filled('end_date'))
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-4">
                            <span class="text-muted">Filter aktif:</span>
                            @if(request()->filled('brand'))
                                <span class="badge badge-info">{{ $selectedBrand->name ?? request('brand') }}</span>
                            @endif
                            @if(request()->filled('type'))
                                <span class="badge badge-info">{{ request('type') }}</span>
                            @endif
                            @if(request()->filled('search'))
                                <span class="badge badge-info">"{{ request('search') }}"</span>
                            @endif
                            @if(request()->filled('start_date') && request()->filled('end_date'))
                                <span class="badge badge-info">
                                    {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}
                                    s/d
                                    {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
                                </span>
                            @endif
                        </div>
                    @endif

                    <div class="row">
                        @forelse($cars as $car)
                            @php
                                $imageIndex = ($loop->iteration % 6) + 1;
                                $carYear = $car->year ? $car->year->format('Y') : '-';
                            @endphp
                            <div class="col-md-6 col-xl-4 mb-4">
                                <div class="card card-product rentify-soft-card h-100">
                                    <div class="card-product-img">
                                        <img src="{{ asset($car->primary_image_path) }}" alt="{{ $car->name }}">
                                        <div class="card-product-badge">
                                            <span class="badge badge-success">{{ ucfirst($car->status) }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between gap-3 mb-2">
                                            <div>
                                                <h5 class="card-title mb-1">{{ $car->name }}</h5>
                                                <p class="text-muted mb-0">{{ $car->brand->name ?? 'Tanpa merek' }}</p>
                                            </div>
                                            <span class="badge badge-light">{{ $car->series_number }}</span>
                                        </div>
                                        <div class="car-specs mb-3">
                                            <span><i class="fas fa-car me-1"></i>{{ $car->type }}</span>
                                            <span><i class="fas fa-calendar me-1"></i>{{ $carYear }}</span>
                                        </div>
                                        <div class="mt-auto d-flex justify-content-between align-items-end">
                                            <div>
                                                <small class="text-muted">Harga per hari</small>
                                                <h4 class="mb-0 text-primary">Rp {{ number_format($car->price, 0, ',', '.') }}</h4>
                                            </div>
                                            <a href="{{ route('user.cars.show', $car->series_number) }}" class="btn btn-primary btn-round btn-sm">
                                                Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="rentify-empty">
                                    <i class="fas fa-car fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted">Mobil tidak ditemukan</h5>
                                    <p class="text-muted">Coba ubah filter atau kata kunci pencarian.</p>
                                    <a href="{{ route('user.cars.index') }}" class="btn btn-primary btn-round">
                                        Reset Filter
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if($cars->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $cars->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
    <style>
        .card-product {
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .card-product:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(31, 58, 90, .12);
        }

        .card-product-img {
            position: relative;
            height: 210px;
            overflow: hidden;
            border-radius: 8px 8px 0 0;
            background: #f1f3f5;
        }

        .card-product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-product-badge {
            position: absolute;
            top: 12px;
            right: 12px;
        }

        .car-specs {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            color: #6c757d;
            font-size: .875rem;
        }
    </style>
@endsection
