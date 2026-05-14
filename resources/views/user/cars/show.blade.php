@extends('layouts.User.master')

@section('title', 'Detail Mobil - Rentify')

@section('content')
    @php
        $isAvailable = in_array($car->status, ['tersedia', 'available', 'Tersedia'], true);
        $carYear = $car->year ? $car->year->format('Y') : '-';
    @endphp

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Detail Mobil</h4>
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
                        <a href="{{ route('user.cars') }}">Mobil</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <span>{{ $car->name }}</span>
                    </li>
                </ul>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-round rentify-soft-card">
                        <div class="car-hero">
                            <img src="{{ asset($car->primary_image_path) }}" alt="{{ $car->name }}">
                            <span class="badge badge-{{ $isAvailable ? 'success' : 'danger' }} car-hero-badge">
                                {{ ucfirst($car->status) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-wrap gap-3">
                                <div>
                                    <h3 class="fw-bold mb-1">{{ $car->name }}</h3>
                                    <p class="text-muted mb-0">{{ $car->brand->name ?? 'Tanpa merek' }} - {{ $car->series_number }}</p>
                                </div>
                                <div class="text-lg-end">
                                    <small class="text-muted d-block">Harga per hari</small>
                                    <h3 class="text-primary mb-0">Rp {{ number_format($car->price, 0, ',', '.') }}</h3>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-4 mb-3">
                                    <div class="spec-card">
                                        <i class="fas fa-car text-primary"></i>
                                        <span>Tipe</span>
                                        <strong>{{ $car->type }}</strong>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <div class="spec-card">
                                        <i class="fas fa-calendar text-success"></i>
                                        <span>Tahun</span>
                                        <strong>{{ $carYear }}</strong>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <div class="spec-card">
                                        <i class="fas fa-check-circle text-info"></i>
                                        <span>Status</span>
                                        <strong>{{ ucfirst($car->status) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($relatedCars->count() > 0)
                        <div class="card card-round mt-4">
                            <div class="card-header">
                                <div class="card-title">Mobil Serupa</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($relatedCars as $relatedCar)
                                        <div class="col-md-6 col-xl-3 mb-3">
                                            <div class="card rentify-soft-card h-100">
                                                <img src="{{ asset($relatedCar->primary_image_path) }}"
                                                    alt="{{ $relatedCar->name }}" class="related-car-img">
                                                <div class="card-body p-3">
                                                    <h6 class="mb-1">{{ $relatedCar->name }}</h6>
                                                    <small class="text-muted d-block mb-2">{{ $relatedCar->type }}</small>
                                                    <a href="{{ route('user.cars.show', $relatedCar->series_number) }}" class="btn btn-sm btn-primary w-100">
                                                        Lihat Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="card card-round sticky-lg-top rentify-booking-card">
                        <div class="card-header">
                            <div class="card-title">Pesan Mobil</div>
                            <p class="card-category">Tanggal akan dihitung otomatis dari harga database.</p>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.orders.store') }}" id="bookingForm">
                                @csrf
                                <input type="hidden" name="car_id" value="{{ $car->series_number }}">

                                <div class="mb-3">
                                    <label for="startDate" class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                                        id="startDate" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="endDate" class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                                        id="endDate" value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="summary-box mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Durasi</span>
                                        <strong id="duration">0 hari</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Harga per hari</span>
                                        <strong>Rp {{ number_format($car->price, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between total-row">
                                        <span>Total estimasi</span>
                                        <strong id="totalCost">Rp 0</strong>
                                    </div>
                                </div>

                                @if($verifiedDocuments < 1)
                                    <div class="alert alert-warning">
                                        <i class="fas fa-file-signature me-2"></i>
                                        Belum ada dokumen yang disetujui. Anda tetap bisa membuat pesanan, tetapi admin perlu memverifikasi dokumen.
                                    </div>
                                @endif

                                <button type="submit" class="btn btn-primary btn-round w-100" {{ $isAvailable ? '' : 'disabled' }}>
                                    <i class="fas fa-check me-2"></i>{{ $isAvailable ? 'Buat Pesanan' : 'Mobil Tidak Tersedia' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
    <style>
        .car-hero {
            position: relative;
            height: 360px;
            overflow: hidden;
            border-radius: 8px 8px 0 0;
            background: #f1f3f5;
        }

        .car-hero img,
        .related-car-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .car-hero-badge {
            position: absolute;
            top: 18px;
            right: 18px;
        }

        .spec-card {
            height: 100%;
            padding: 16px;
            border: 1px solid #eef1f5;
            border-radius: 8px;
            background: #fbfcfe;
        }

        .spec-card i,
        .spec-card span,
        .spec-card strong {
            display: block;
        }

        .spec-card span {
            margin-top: 10px;
            color: #6c757d;
            font-size: .8rem;
        }

        .related-car-img {
            height: 120px;
            border-radius: 8px 8px 0 0;
        }

        .rentify-booking-card {
            top: 90px;
        }

        .summary-box {
            padding: 16px;
            border-radius: 8px;
            background: #f8fafc;
        }

        .total-row {
            padding-top: 12px;
            border-top: 1px solid #e7ebf0;
            color: #1572e8;
        }
    </style>
@endsection

@section('extraJS')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDate = document.getElementById('startDate');
            const endDate = document.getElementById('endDate');
            const duration = document.getElementById('duration');
            const totalCost = document.getElementById('totalCost');
            const carPrice = {{ (float) $car->price }};

            function formatCurrency(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
            }

            function calculateDuration() {
                if (!startDate.value || !endDate.value) {
                    duration.textContent = '0 hari';
                    totalCost.textContent = 'Rp 0';
                    return;
                }

                const start = new Date(startDate.value);
                const end = new Date(endDate.value);

                if (end < start) {
                    duration.textContent = '0 hari';
                    totalCost.textContent = 'Rp 0';
                    return;
                }

                const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
                duration.textContent = days + ' hari';
                totalCost.textContent = formatCurrency(days * carPrice);
            }

            startDate.addEventListener('change', function() {
                endDate.min = startDate.value;
                calculateDuration();
            });

            endDate.addEventListener('change', calculateDuration);
            calculateDuration();
        });
    </script>
@endsection
