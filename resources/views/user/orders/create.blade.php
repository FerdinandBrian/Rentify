@extends('layouts.User.master')

@section('title', 'Pemesanan Mobil - Rentify')

@section('content')
    @php
        $isAvailable = in_array(strtolower($car->status), ['tersedia', 'available'], true);
        $hasApprovedDocument = $verifiedDocuments > 0;
        $canOrder = $isAvailable && $hasApprovedDocument;
        $carYear = $car->year ? $car->year->format('Y') : '-';
        $customer = auth()->user();
    @endphp

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Pemesanan Mobil</h4>
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
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.cars.show', $car->series_number) }}">{{ $car->name }}</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <span>Pesan</span>
                    </li>
                </ul>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-round rentify-soft-card">
                        <div class="booking-hero">
                            <img src="{{ asset('assets/img/examples/product1.jpg') }}" alt="{{ $car->name }}">
                            <span class="badge badge-{{ $isAvailable ? 'success' : 'danger' }} booking-hero-badge">
                                {{ ucfirst($car->status) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-wrap gap-3 mb-4">
                                <div>
                                    <h3 class="fw-bold mb-1">{{ $car->name }}</h3>
                                    <p class="text-muted mb-0">{{ $car->brand->name ?? 'Tanpa merek' }} - {{ $car->series_number }}</p>
                                </div>
                                <div class="text-lg-end">
                                    <small class="text-muted d-block">Harga per hari</small>
                                    <h3 class="text-primary mb-0">Rp {{ number_format($car->price, 0, ',', '.') }}</h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="spec-card">
                                        <i class="fas fa-car text-primary"></i>
                                        <span>Tipe</span>
                                        <strong>{{ $car->type }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="spec-card">
                                        <i class="fas fa-calendar text-success"></i>
                                        <span>Tahun</span>
                                        <strong>{{ $carYear }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="spec-card">
                                        <i class="fas fa-id-card text-info"></i>
                                        <span>No. Seri</span>
                                        <strong>{{ $car->series_number }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-round mt-4">
                        <div class="card-header">
                            <div class="card-title">Data Penyewa</div>
                            <p class="card-category">Data diambil dari profil akun customer.</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="info-row">
                                        <span>Nama</span>
                                        <strong>{{ $customer->name }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-row">
                                        <span>Email</span>
                                        <strong>{{ $customer->email ?? '-' }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-row">
                                        <span>No. Telepon</span>
                                        <strong>{{ $customer->call_number ?? $customer->phone ?? '-' }}</strong>
                                    </div>
                                </div>
                            </div>

                            @if($verifiedDocuments < 1)
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-file-signature me-2"></i>
                                    Belum ada dokumen yang disetujui. Lengkapi dokumen dan tunggu persetujuan admin sebelum membuat pesanan.
                                </div>
                            @else
                                <div class="alert alert-success mb-0">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Dokumen Anda sudah memiliki data yang disetujui.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-round sticky-lg-top rentify-order-card">
                        <div class="card-header">
                            <div class="card-title">Form Pemesanan</div>
                            <p class="card-category">Pilih tanggal sewa untuk melihat estimasi total.</p>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.orders.store') }}" id="bookingForm">
                                @csrf
                                <input type="hidden" name="car_id" value="{{ $car->series_number }}">

                                <div class="mb-3">
                                    <label for="startDate" class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="startDate"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="endDate" class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="end_date" id="endDate"
                                        class="form-control @error('end_date') is-invalid @enderror"
                                        value="{{ old('end_date') }}" min="{{ old('start_date', date('Y-m-d')) }}" required>
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

                                <button type="submit" class="btn btn-primary btn-round w-100" {{ $canOrder ? '' : 'disabled' }}>
                                    <i class="fas fa-check me-2"></i>
                                    @if(! $isAvailable)
                                        Mobil Tidak Tersedia
                                    @elseif(! $hasApprovedDocument)
                                        Dokumen Belum Disetujui
                                    @else
                                        Buat Pesanan
                                    @endif
                                </button>
                                <a href="{{ route('user.cars.show', $car->series_number) }}" class="btn btn-outline-primary btn-round w-100 mt-2">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
                                </a>
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
        .booking-hero {
            position: relative;
            height: 320px;
            overflow: hidden;
            border-radius: 8px 8px 0 0;
            background: #f1f3f5;
        }

        .booking-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .booking-hero-badge {
            position: absolute;
            top: 18px;
            right: 18px;
        }

        .spec-card,
        .info-row {
            height: 100%;
            padding: 16px;
            border: 1px solid #eef1f5;
            border-radius: 8px;
            background: #fbfcfe;
        }

        .spec-card i,
        .spec-card span,
        .spec-card strong,
        .info-row span,
        .info-row strong {
            display: block;
        }

        .spec-card span,
        .info-row span {
            margin-top: 10px;
            color: #6c757d;
            font-size: .8rem;
        }

        .info-row span {
            margin-top: 0;
            margin-bottom: 6px;
        }

        .rentify-order-card {
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

        @media (max-width: 991.98px) {
            .booking-hero {
                height: 240px;
            }
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
