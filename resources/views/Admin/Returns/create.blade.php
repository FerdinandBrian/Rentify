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

            <form action="{{ route('returns.store') }}" method="POST" id="returnForm" onsubmit="return confirm('Konfirmasi pengembalian mobil ini? Tindakan ini tidak dapat dibatalkan.')">
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
                                    $days = $order->start_rent && $order->end_rent ? $order->start_rent->diffInDays($order->end_rent) + 1 : 0;
                                    $basePayment = $order->payments->first();
                                    $basePrice = ($basePayment && $basePayment->total_price !== null && $basePayment->total_price > 0)
                                        ? $basePayment->total_price
                                        : (($order->car->price ?? 0) * $days);
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

                        {{-- Car Condition --}}
                        <div class="card card-round mb-4">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    <i class="fa fa-clipboard-check me-2 text-info"></i>Kondisi Mobil Saat Diterima
                                </h4>
                            </div>
                            <div class="card-body">
                                <label for="return_condition_note" class="form-label fw-bold">Catatan Kondisi</label>
                                <textarea name="return_condition_note" id="return_condition_note" class="form-control" rows="4" maxlength="1000" placeholder="Contoh: ada gores kecil di bumper belakang.">{{ old('return_condition_note') }}</textarea>
                                @error('return_condition_note')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
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

                                <!-- Payment Simulation Area (Dummy) -->
                                <div id="payment_simulation_wrapper" class="d-none mb-4 card border border-warning bg-light-warning">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3 text-warning">
                                            <i class="fas fa-desktop me-2"></i>Simulasi Pembayaran (Dummy)
                                        </h6>
                                        
                                        <!-- QRIS Panel -->
                                        <div id="sim_QRIS" class="sim-panel d-none text-center">
                                            <p class="text-muted small">Pindai kode QRIS di bawah ini untuk membayar:</p>
                                            <div class="d-inline-block p-3 bg-white border rounded mb-3">
                                                <svg width="150" height="150" viewBox="0 0 100 100" class="d-block mx-auto">
                                                    <rect width="100" height="100" fill="#f8f9fa"/>
                                                    <!-- Corner anchor squares -->
                                                    <rect x="5" y="5" width="25" height="25" fill="#333" stroke="#fff" stroke-width="2"/>
                                                    <rect x="10" y="10" width="15" height="15" fill="#fff"/>
                                                    <rect x="13" y="13" width="9" height="9" fill="#333"/>
                                                    
                                                    <rect x="70" y="5" width="25" height="25" fill="#333" stroke="#fff" stroke-width="2"/>
                                                    <rect x="75" y="10" width="15" height="15" fill="#fff"/>
                                                    <rect x="78" y="13" width="9" height="9" fill="#333"/>
                                                    
                                                    <rect x="5" y="70" width="25" height="25" fill="#333" stroke="#fff" stroke-width="2"/>
                                                    <rect x="10" y="75" width="15" height="15" fill="#fff"/>
                                                    <rect x="13" y="78" width="9" height="9" fill="#333"/>
                                                    
                                                    <!-- Fake QR noise pattern -->
                                                    <rect x="35" y="10" width="10" height="10" fill="#333"/>
                                                    <rect x="50" y="20" width="10" height="10" fill="#333"/>
                                                    <rect x="35" y="40" width="15" height="15" fill="#333"/>
                                                    <rect x="60" y="40" width="10" height="20" fill="#333"/>
                                                    <rect x="80" y="80" width="15" height="15" fill="#333"/>
                                                    <rect x="40" y="75" width="20" height="10" fill="#333"/>
                                                    <rect x="70" y="70" width="10" height="10" fill="#333"/>
                                                </svg>
                                                <span class="fw-bold mt-2 d-block text-uppercase" style="font-size: 0.8rem; letter-spacing: 2px; color: #333;">Rentify QRIS</span>
                                            </div>
                                            <p class="text-danger fw-bold mb-0">Total Tagihan: <span class="sim-grand-total">Rp 0</span></p>
                                        </div>

                                        <!-- Virtual Account Panel -->
                                        <div id="sim_Virtual_Account" class="sim-panel d-none">
                                            <p class="text-muted small mb-2">Silakan transfer ke nomor Virtual Account berikut:</p>
                                            <div class="input-group mb-2">
                                                <span class="input-group-text bg-primary text-white font-bold" style="font-size: 0.85rem;">Permata / Mandiri VA</span>
                                                <input type="text" class="form-control fw-bold" id="va_number_val" value="8277081234567890" readonly>
                                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('va_number_val')">
                                                    <i class="fas fa-copy"></i> Salin
                                                </button>
                                            </div>
                                            <p class="text-muted small mb-0">Pembayaran akan diverifikasi secara otomatis oleh sistem.</p>
                                        </div>

                                        <!-- Transfer Bank Panel -->
                                        <div id="sim_Transfer_Bank" class="sim-panel d-none">
                                            <p class="text-muted small mb-2">Silakan transfer manual ke rekening bank berikut:</p>
                                            <div class="border rounded p-3 bg-white mb-2">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted small">Nama Bank:</span>
                                                    <span class="fw-bold small">Bank Central Asia (BCA)</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2 align-items-center">
                                                    <span class="text-muted small">No Rekening:</span>
                                                    <span class="fw-bold text-primary small">
                                                        <span id="bank_acc_val">812738471928</span>
                                                        <button class="btn btn-sm btn-link p-0 ms-2" type="button" onclick="copyToClipboard('bank_acc_val')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted small">Atas Nama:</span>
                                                    <span class="fw-bold small">PT Rentify Mobil Indonesia</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Cash Panel -->
                                        <div id="sim_Cash" class="sim-panel d-none text-center">
                                            <p class="mb-0 text-muted small">Customer membayar langsung menggunakan uang tunai (cash) ke kasir Rentify.</p>
                                            <span class="badge bg-success mt-2">Terima pembayaran tunai di kasir</span>
                                        </div>

                                        <!-- Debit Card Panel -->
                                        <div id="sim_Debit_Card" class="sim-panel d-none text-center">
                                            <p class="mb-0 text-muted small">Gunakan mesin EDC Rentify di meja administrasi untuk memproses kartu Debit/Kredit.</p>
                                            <span class="badge bg-primary mt-2">Gesek / Tempel Kartu Debit/Kredit</span>
                                        </div>

                                        <!-- Simulation Success Button -->
                                        <div class="mt-3 text-center border-top pt-3">
                                            <button type="button" id="btnSimulatePayment" class="btn btn-success btn-sm btn-round shadow-sm px-4">
                                                <i class="fas fa-check-circle me-1"></i> Konfirmasi Pembayaran Sukses (Simulasi)
                                            </button>
                                        </div>
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
                            <button type="submit" class="btn btn-primary btn-round px-4">
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
        
        // Update simulation total text if function exists
        if (typeof updateSimTotal === 'function') {
            updateSimTotal();
        }
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

    // Payment Simulation Logic
    const paymentMethodSelect = document.getElementById('payment_method');
    const paymentStatusSelect = document.getElementById('payment_status');
    const simulationWrapper = document.getElementById('payment_simulation_wrapper');
    const btnSimulatePayment = document.getElementById('btnSimulatePayment');

    function updateSimTotal() {
        const grandTotalText = document.getElementById('grandTotal').textContent;
        document.querySelectorAll('.sim-grand-total').forEach(el => {
            el.textContent = grandTotalText;
        });
    }

    function handlePaymentMethodChange() {
        const val = paymentMethodSelect.value;
        
        // Hide all panels
        document.querySelectorAll('.sim-panel').forEach(p => p.classList.add('d-none'));
        
        if (val) {
            simulationWrapper.classList.remove('d-none');
            // Show corresponding panel
            const panelId = 'sim_' + val.replace(' ', '_');
            const panel = document.getElementById(panelId);
            if (panel) {
                panel.classList.remove('d-none');
            }
            updateSimTotal();
        } else {
            simulationWrapper.classList.add('d-none');
        }
    }

    if (paymentMethodSelect) {
        paymentMethodSelect.addEventListener('change', handlePaymentMethodChange);
        // Run on load to restore state if needed (e.g. on validation error)
        handlePaymentMethodChange();
    }

    if (btnSimulatePayment) {
        btnSimulatePayment.addEventListener('click', function() {
            if (paymentStatusSelect) {
                paymentStatusSelect.value = 'paid';
            }
            swal({
                title: "Simulasi Pembayaran Berhasil!",
                text: "Status pembayaran otomatis diubah menjadi Lunas (Paid).",
                icon: "success",
                button: "OK"
            });
        });
    }

    function copyToClipboard(elementId) {
        const input = document.getElementById(elementId);
        let text = "";
        if (input.tagName === 'INPUT') {
            text = input.value;
        } else {
            text = input.textContent;
        }
        navigator.clipboard.writeText(text).then(() => {
            swal({
                title: "Teks Disalin",
                text: "Berhasil menyalin ke papan klip!",
                icon: "success",
                buttons: false,
                timer: 1500
            });
        }).catch(err => {
            console.error('Failed to copy text: ', err);
        });
    }
</script>
@endsection
