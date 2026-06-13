@extends('layouts.User.master')

@section('title', 'Detail Mobil - Rentify')

@section('content')
    @php
        $isAvailable = in_array(strtolower($car->status), ['tersedia', 'available'], true);
        $hasApprovedDocument = $verifiedDocuments > 0;
        $canOrder = $isAvailable && $hasApprovedDocument;
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
                        <a href="{{ route('user.cars.index') }}">Mobil</a>
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

                    {{-- Feedback Form Section --}}
                    <div class="card card-round mt-4">
                        <div class="card-header">
                            <div class="card-title"><i class="fas fa-star me-2"></i>Berikan Ulasan</div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                </div>
                            @endif

                            @if($hasSubmittedFeedback)
                                <div class="text-center py-4">
                                    <i class="fas fa-check-circle text-success" style="font-size: 2.5rem;"></i>
                                    <p class="mt-3 mb-0 fw-bold">Anda sudah memberikan ulasan untuk mobil ini.</p>
                                    <small class="text-muted">Terima kasih atas feedback Anda!</small>
                                </div>
                            @else
                                <form action="{{ route('user.feedback.store', $car->series_number) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Rating</label>
                                        <div class="star-rating-input" id="starRating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star star-select" data-value="{{ $i }}" style="font-size: 28px; cursor: pointer; color: #dee2e6; transition: color 0.2s;"></i>
                                            @endfor
                                            <input type="hidden" name="star" id="starValue" value="{{ old('star', '') }}">
                                        </div>
                                        @error('star')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="feedbackMessage" class="form-label fw-bold">Pesan Ulasan</label>
                                        <textarea name="message" id="feedbackMessage" class="form-control @error('message') is-invalid @enderror"
                                                  rows="4" placeholder="Bagikan pengalaman Anda menggunakan mobil ini..." maxlength="1000">{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-round" id="submitFeedback">
                                        <i class="fas fa-paper-plane me-2"></i>Kirim Ulasan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-round sticky-lg-top rentify-booking-card">
                        <div class="card-header">
                            <div class="card-title">Pesan Mobil</div>
                            <p class="card-category">Lanjutkan ke halaman pemesanan untuk memilih tanggal dan cek estimasi biaya.</p>
                        </div>
                        <div class="card-body">
                            <div class="summary-box mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Mobil</span>
                                    <strong>{{ $car->name }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Harga per hari</span>
                                    <strong>Rp {{ number_format($car->price, 0, ',', '.') }}</strong>
                                </div>
                                <div class="d-flex justify-content-between total-row">
                                    <span>Status</span>
                                    <strong>{{ ucfirst($car->status) }}</strong>
                                </div>
                            </div>

                            @if($verifiedDocuments < 1)
                                <div class="alert alert-warning">
                                    <i class="fas fa-file-signature me-2"></i>
                                    Belum ada dokumen yang disetujui. Lengkapi dokumen dan tunggu persetujuan admin sebelum membuat pesanan.
                                </div>
                            @endif

                            <a href="{{ route('user.orders.create', $car->series_number) }}"
                                class="btn btn-primary btn-round w-100 {{ $canOrder ? '' : 'disabled' }}"
                                aria-disabled="{{ $canOrder ? 'false' : 'true' }}">
                                <i class="fas fa-calendar-check me-2"></i>
                                @if(! $isAvailable)
                                    Mobil Tidak Tersedia
                                @elseif(! $hasApprovedDocument)
                                    Dokumen Belum Disetujui
                                @else
                                    Lanjut Pesan
                                @endif
                            </a>
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

        .car-status-badge {
            background: #31ce36 !important;
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

        .star-rating-input {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .star-rating-input .star-select:hover,
        .star-rating-input .star-select.active {
            color: #ffc107 !important;
        }

        .star-rating-input .star-select.hover-preview {
            color: #ffdb4d !important;
        }
    </style>
@endsection

@section('extraJS')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('#starRating .star-select');
            const input = document.getElementById('starValue');

            if (!stars.length || !input) return;

            // Restore old value if validation failed
            const oldVal = parseInt(input.value);
            if (oldVal >= 1 && oldVal <= 5) {
                stars.forEach(function (s) {
                    if (parseInt(s.dataset.value) <= oldVal) {
                        s.classList.add('active');
                    }
                });
            }

            stars.forEach(function (star) {
                star.addEventListener('click', function () {
                    const val = parseInt(this.dataset.value);
                    input.value = val;
                    stars.forEach(function (s) {
                        s.classList.toggle('active', parseInt(s.dataset.value) <= val);
                    });
                });

                star.addEventListener('mouseenter', function () {
                    const val = parseInt(this.dataset.value);
                    stars.forEach(function (s) {
                        s.classList.toggle('hover-preview', parseInt(s.dataset.value) <= val);
                    });
                });

                star.addEventListener('mouseleave', function () {
                    stars.forEach(function (s) {
                        s.classList.remove('hover-preview');
                    });
                });
            });
        });
    </script>
@endsection
