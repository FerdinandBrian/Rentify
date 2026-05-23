@extends('layouts.Admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Proses Pengembalian</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('returns.index') }}">Pengembalian Mobil</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="#">Proses</a></li>
                </ul>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('returns.store') }}" method="POST" id="returnForm">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <div class="row">
                    {{-- Left Column: Order Info --}}
                    <div class="col-md-4">
                        <div class="card card-round">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    <i class="fa fa-info-circle me-2 text-primary"></i>Info Pesanan
                                </h4>
                            </div>
                            <div class="card-body d-flex flex-column gap-3">
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase">ID Pesanan</span>
                                    <h6 class="mb-0 fw-bold">{{ $order->id }}</h6>
                                </div>
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase">Pelanggan</span>
                                    <h6 class="mb-0 fw-bold">{{ $order->name }}</h6>
                                    <small class="text-muted">{{ $order->call_number }}</small>
                                </div>
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase">Mobil</span>
                                    <h6 class="mb-0 fw-bold text-primary">{{ $order->car->name ?? '-' }}</h6>
                                    <small class="text-muted">{{ $order->Car_series_number }}</small>
                                </div>
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase">Periode Sewa</span>
                                    <h6 class="mb-0">{{ $order->start_rent?->format('d M Y') ?? '-' }}</h6>
                                    <small class="text-muted">s/d {{ $order->end_rent?->format('d M Y') ?? '-' }}</small>
                                </div>
                                @php
                                    $basePayment = $order->payments->first();
                                    $basePrice = $basePayment?->total_price ?? 0;
                                    $isOverdue = $order->end_rent && now()->isAfter($order->end_rent);
                                @endphp
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase">Total Sewa</span>
                                    <h5 class="mb-0 fw-bold text-success">Rp {{ number_format($basePrice, 0, ',', '.') }}</h5>
                                </div>
                                @if ($isOverdue)
                                    <div class="alert alert-warning py-2 mb-0">
                                        <i class="fa fa-exclamation-triangle me-1"></i>
                                        <strong>Terlambat!</strong> Batas kembali: {{ $order->end_rent?->format('d M Y H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Return Form --}}
                    <div class="col-md-8">

                        {{-- Fuel Level --}}
                        <div class="card card-round mb-4">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    <i class="fa fa-gas-pump me-2 text-warning"></i>Kondisi Bahan Bakar
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row g-2" id="fuelLevelGroup">
                                    @foreach ([
                                        ['value' => 'full',    'label' => 'Full (F)',  'icon' => '🟢'],
                                        ['value' => '3/4',     'label' => '3/4',       'icon' => '🟡'],
                                        ['value' => '1/2',     'label' => '1/2',       'icon' => '🟠'],
                                        ['value' => '1/4',     'label' => '1/4',       'icon' => '🔴'],
                                        ['value' => 'empty',   'label' => 'Kosong (E)','icon' => '⚫'],
                                    ] as $fuel)
                                        <div class="col-auto">
                                            <input type="radio" class="btn-check" name="fuel_level"
                                                id="fuel_{{ $fuel['value'] }}" value="{{ $fuel['value'] }}"
                                                {{ old('fuel_level') === $fuel['value'] ? 'checked' : '' }} required>
                                            <label class="btn btn-outline-secondary btn-round px-4"
                                                   for="fuel_{{ $fuel['value'] }}">
                                                {{ $fuel['icon'] }} {{ $fuel['label'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('fuel_level')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Penalties --}}
                        <div class="card card-round mb-4">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    <i class="fa fa-exclamation-triangle me-2 text-danger"></i>Denda
                                </h4>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small mb-3">Centang denda yang berlaku sesuai kondisi kendaraan.</p>

                                {{-- Standard Penalties --}}
                                @php
                                    $standardPenalties = [
                                        'Late Return'    => 100000,
                                        'Smoking in Car' => 500000,
                                        'Dirty Interior' => 200000,
                                    ];
                                @endphp

                                <div class="d-flex flex-column gap-3 mb-4">
                                    @foreach ($standardPenalties as $type => $amount)
                                        <div class="d-flex align-items-center justify-content-between p-3 border rounded-3 penalty-item"
                                             id="penalty-item-{{ $loop->index }}"
                                             style="cursor:pointer; transition: background 0.2s;"
                                             onclick="document.getElementById('chk_{{ $loop->index }}').click()">
                                            <div class="d-flex align-items-center gap-3">
                                                <input class="form-check-input penalty-checkbox mt-0" type="checkbox"
                                                       name="penalties[]" id="chk_{{ $loop->index }}"
                                                       value="{{ $type }}"
                                                       data-amount="{{ $amount }}"
                                                       onclick="event.stopPropagation()"
                                                       onchange="recalcTotal()">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">{{ $type }}</h6>
                                                    <small class="text-muted">Denda standar</small>
                                                </div>
                                            </div>
                                            <span class="fw-bold text-danger">Rp {{ number_format($amount, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Custom Penalty --}}
                                <div class="border-top pt-3">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="toggleCustomPenalty"
                                               onchange="toggleCustomPenaltyForm(this.checked)">
                                        <label class="form-check-label fw-bold" for="toggleCustomPenalty">
                                            Tambah Denda Kustom
                                        </label>
                                    </div>

                                    <div id="customPenaltyForm" class="d-none">
                                        <div class="row g-3">
                                            <div class="col-md-7">
                                                <label class="form-label">Keterangan Denda</label>
                                                <input type="text" name="custom_penalty_desc" id="custom_penalty_desc"
                                                       class="form-control"
                                                       placeholder="Contoh: Kerusakan bumper depan"
                                                       value="{{ old('custom_penalty_desc') }}"
                                                       oninput="recalcTotal()">
                                                @error('custom_penalty_desc')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">Nominal Denda (Rp)</label>
                                                <input type="number" name="custom_penalty_amount" id="custom_penalty_amount"
                                                       class="form-control" min="0" step="1000"
                                                       placeholder="0"
                                                       value="{{ old('custom_penalty_amount') }}"
                                                       oninput="recalcTotal()">
                                                @error('custom_penalty_amount')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Conclusion --}}
                        <div class="card card-round mb-4">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    <i class="fa fa-money-bill-wave me-2 text-success"></i>Kesimpulan Pembayaran
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="payment_method" class="form-label fw-bold">Metode Pembayaran</label>
                                        <select name="payment_method" id="payment_method" class="form-select">
                                            <option value="">— Tidak ada pembayaran tambahan —</option>
                                            @foreach (['Cash', 'QRIS', 'Transfer Bank', 'Virtual Account', 'Debit Card'] as $method)
                                                <option value="{{ $method }}" {{ old('payment_method') === $method ? 'selected' : '' }}>
                                                    {{ $method }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="payment_status" class="form-label fw-bold">Status Pembayaran</label>
                                        <select name="payment_status" id="payment_status" class="form-select">
                                            <option value="paid"    {{ old('payment_status', 'paid') === 'paid'    ? 'selected' : '' }}>Lunas (Paid)</option>
                                            <option value="pending" {{ old('payment_status') === 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Price Summary --}}
                                <div class="bg-light rounded-3 p-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Total Sewa</span>
                                        <span class="fw-bold">Rp {{ number_format($basePrice, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Total Denda</span>
                                        <span class="fw-bold text-danger" id="penaltySummary">Rp 0</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold fs-5">Grand Total</span>
                                        <span class="fw-bold fs-5 text-success" id="grandTotal">
                                            Rp {{ number_format($basePrice, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('returns.index') }}" class="btn btn-black btn-border btn-round">
                                <i class="fa fa-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-round px-4"
                                    onclick="return confirm('Konfirmasi pengembalian mobil ini? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fa fa-check-circle me-1"></i> Selesaikan Pengembalian
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('extraJS')
<script>
    const basePrice = {{ $basePrice }};

    function recalcTotal() {
        let penaltyTotal = 0;

        // Standard checkboxes
        document.querySelectorAll('.penalty-checkbox:checked').forEach(cb => {
            penaltyTotal += parseFloat(cb.dataset.amount || 0);
        });

        // Custom penalty
        const customAmount = parseFloat(document.getElementById('custom_penalty_amount')?.value || 0);
        if (!isNaN(customAmount) && customAmount > 0) {
            penaltyTotal += customAmount;
        }

        const grand = basePrice + penaltyTotal;

        document.getElementById('penaltySummary').textContent = 'Rp ' + formatRp(penaltyTotal);
        document.getElementById('grandTotal').textContent = 'Rp ' + formatRp(grand);
    }

    function formatRp(value) {
        return value.toLocaleString('id-ID');
    }

    function toggleCustomPenaltyForm(show) {
        const form = document.getElementById('customPenaltyForm');
        form.classList.toggle('d-none', !show);
        if (!show) {
            document.getElementById('custom_penalty_desc').value = '';
            document.getElementById('custom_penalty_amount').value = '';
            recalcTotal();
        }
    }

    // Highlight selected penalty rows
    document.querySelectorAll('.penalty-checkbox').forEach(cb => {
        cb.addEventListener('change', function () {
            const item = this.closest('.penalty-item');
            if (this.checked) {
                item.style.background = '#fff3cd';
                item.style.borderColor = '#ffc107';
            } else {
                item.style.background = '';
                item.style.borderColor = '';
            }
        });
    });
</script>
@endsection
