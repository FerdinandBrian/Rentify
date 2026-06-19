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
                            <img src="{{ asset($car->primary_image_path) }}" alt="{{ $car->name }}">
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

                                {{-- ─── Pilihan Add-on ─────────────────────────── --}}
                                @if(isset($addons) && $addons->count())
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Layanan Tambahan <span class="text-muted fw-normal">(opsional)</span></label>
                                    @error('addon_ids')
                                        <div class="text-danger small mb-1">{{ $message }}</div>
                                    @enderror
                                    <div class="row g-2">
                                        @foreach($addons as $addon)
                                            @php
                                                $pricePerDay  = $addon->price_per_day  ?? 0;
                                                $pricePerUnit = $addon->price_per_unit ?? 0;
                                                $addonName    = strtolower($addon->name);
                                                $isPerDay     = str_contains($addonName, 'driver');
                                                $displayPrice = $isPerDay ? $pricePerDay : $pricePerUnit;
                                                $priceLabel   = $isPerDay ? '/hari' : '/unit';

                                                $addonIcon = match(true) {
                                                    str_contains($addonName, 'driver')                                           => 'fas fa-user-tie',
                                                    str_contains($addonName, 'gps')                                              => 'fas fa-map-marker-alt',
                                                    str_contains($addonName, 'insurance') || str_contains($addonName, 'asuransi') => 'fas fa-shield-alt',
                                                    str_contains($addonName, 'baby') || str_contains($addonName, 'seat')          => 'fas fa-baby',
                                                    default                                                                       => 'fas fa-plus-circle',
                                                };
                                            @endphp
                                            <div class="col-12">
                                                {{-- Hapus atribut `for` — input sudah DI DALAM label.
                                                     Kalau `for` dan wrapping keduanya ada, satu klik
                                                     toggle dua kali sehingga checkbox balik ke semula. --}}
                                                <label class="addon-card w-100">
                                                    <input type="checkbox"
                                                        name="addon_ids[]"
                                                        value="{{ $addon->id }}"
                                                        class="addon-checkbox"
                                                        data-price="{{ $displayPrice }}"
                                                        data-per-day="{{ $isPerDay ? 1 : 0 }}"
                                                        {{ in_array($addon->id, old('addon_ids', [])) ? 'checked' : '' }}>
                                                    <div class="addon-card-inner d-flex align-items-center gap-3">
                                                        <div class="addon-icon">
                                                            <i class="{{ $addonIcon }}"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="fw-semibold addon-name">{{ $addon->name }}</div>
                                                            <div class="text-muted small addon-price-label">
                                                                Rp {{ number_format($displayPrice, 0, ',', '.') }} {{ $priceLabel }}
                                                            </div>
                                                        </div>
                                                        <div class="addon-check-indicator">
                                                            <i class="fas fa-check-circle"></i>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                {{-- ─── Ringkasan Biaya ──────────────────────────── --}}
                                <div class="summary-box mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Durasi</span>
                                        <strong id="duration">0 hari</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Harga sewa</span>
                                        <strong id="baseCost">Rp 0</strong>
                                    </div>
                                    <div id="addonSummaryRows"></div>
                                    <div class="d-flex justify-content-between total-row mt-2">
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

        /* ── Add-on cards ── */
        .addon-card {
            cursor: pointer;
            margin-bottom: 0;
        }

        .addon-card-inner {
            padding: 10px 14px;
            border: 2px solid #e7ebf0;
            border-radius: 10px;
            background: #fff;
            transition: border-color .18s, background .18s, box-shadow .18s;
        }

        .addon-card:hover .addon-card-inner {
            border-color: #a0bffc;
            background: #f5f8ff;
        }

        .addon-checkbox:checked + .addon-card-inner,
        .addon-card input:checked ~ .addon-card-inner {
            border-color: #1572e8;
            background: #eef3fd;
            box-shadow: 0 0 0 3px rgba(21,114,232,.12);
        }

        /* Sembunyikan checkbox asli tapi tetap fungsional (bukan display:none) */
        .addon-checkbox {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
            pointer-events: none;
        }

        /* Styling aktif via :has() — didukung semua browser modern */
        .addon-card:has(input:checked) .addon-card-inner {
            border-color: #1572e8;
            background: #eef3fd;
            box-shadow: 0 0 0 3px rgba(21,114,232,.12);
        }

        .addon-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #eef3fd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1572e8;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .addon-check-indicator {
            color: #c8d6f0;
            font-size: 1.2rem;
            transition: color .18s;
        }

        .addon-card:has(input:checked) .addon-check-indicator {
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
        document.addEventListener('DOMContentLoaded', function () {
            const startDateEl     = document.getElementById('startDate');
            const endDateEl       = document.getElementById('endDate');
            const durationEl      = document.getElementById('duration');
            const baseCostEl      = document.getElementById('baseCost');
            const totalCostEl     = document.getElementById('totalCost');
            const addonSummaryEl  = document.getElementById('addonSummaryRows');
            const addonCheckboxes = document.querySelectorAll('.addon-checkbox');
            const carPrice        = {{ (float) $car->price }};

            // Pastikan elemen wajib tersedia sebelum lanjut
            if (!startDateEl || !endDateEl || !durationEl || !totalCostEl) return;

            function fmt(value) {
                return 'Rp ' + Math.round(value).toLocaleString('id-ID');
            }

            function getDays() {
                if (!startDateEl.value || !endDateEl.value) return 0;
                const s = new Date(startDateEl.value);
                const e = new Date(endDateEl.value);
                if (e < s) return 0;
                return Math.round((e - s) / 86400000) + 1;
            }

            function recalculate() {
                const days     = getDays();
                const baseCost = carPrice * days;

                // Update durasi & harga sewa
                durationEl.textContent = days > 0 ? days + ' hari' : '0 hari';
                if (baseCostEl) baseCostEl.textContent = days > 0 ? fmt(baseCost) : 'Rp 0';

                // Hitung add-on yang dicentang
                let addonTotal    = 0;
                let addonHtml     = '';

                addonCheckboxes.forEach(function (cb) {
                    if (!cb.checked || days === 0) return;
                    const price  = parseFloat(cb.dataset.price) || 0;
                    const perDay = cb.dataset.perDay === '1';
                    const cost   = perDay ? price * days : price;
                    addonTotal  += cost;

                    const label = cb.closest('label');
                    const name  = label
                        ? (label.querySelector('.addon-name')?.textContent.trim() ?? 'Add-on')
                        : 'Add-on';

                    addonHtml +=
                        '<div class="d-flex justify-content-between mb-2">' +
                            '<span class="text-muted small"><i class="fas fa-plus me-1"></i>' + name + '</span>' +
                            '<small class="text-muted">' + fmt(cost) + '</small>' +
                        '</div>';
                });

                if (addonSummaryEl) addonSummaryEl.innerHTML = addonHtml;
                totalCostEl.textContent = days > 0 ? fmt(baseCost + addonTotal) : 'Rp 0';
            }

            // ── Event listeners ─────────────────────────────────────
            startDateEl.addEventListener('change', function () {
                endDateEl.min = startDateEl.value;
                recalculate();
            });

            endDateEl.addEventListener('change', recalculate);

            // Satu listener untuk semua addon checkbox
            addonCheckboxes.forEach(function (cb) {
                cb.addEventListener('change', recalculate);
            });

            recalculate(); // inisialisasi awal
        });
    </script>
@endsection
