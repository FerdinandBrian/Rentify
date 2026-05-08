@php
    $selectedPayment = $denda?->payments->first();
    $selectedOrder = $selectedPayment?->order;
    $selectedCarId = old('car_series_number', $selectedOrder?->Car_series_number);
    $selectedPaymentId = old('payment_id', $selectedPayment?->id);
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="car_series_number">ID Mobil</label>
            <select id="car_series_number" name="car_series_number" class="form-select" required>
                <option value="">Pilih ID mobil</option>
                @foreach ($formOptions['cars'] as $car)
                    <option value="{{ $car->series_number }}" @selected($selectedCarId === $car->series_number)>
                        {{ $car->series_number }} - {{ $car->name }}
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Payment akan difilter sesuai mobil yang dipilih.</small>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="payment_id">Payment / Pesanan</label>
            <select id="payment_id" name="payment_id" class="form-select" required>
                <option value="">Pilih payment</option>
                @foreach ($formOptions['payments'] as $payment)
                    @php
                        $order = $payment->order;
                        $car = $order?->car;
                        $carSeries = $car->series_number ?? $order?->Car_series_number;
                    @endphp
                    <option value="{{ $payment->id }}" data-car="{{ $carSeries ?? '' }}" @selected((string) $selectedPaymentId === (string) $payment->id)>
                        #{{ $payment->id }} - {{ $order->id ?? '-' }} - {{ $carSeries ?? '-' }} - {{ $order->name ?? '-' }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="type">Keterangan Denda</label>
            <input id="type" type="text" name="type" class="form-control"
                value="{{ old('type', $denda->type ?? '') }}"
                placeholder="Contoh: Terlambat mengembalikan mobil" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="total_penalty">Nominal Denda</label>
            <input id="total_penalty" type="number" name="total_penalty" class="form-control" min="0" step="1000"
                value="{{ old('total_penalty', $denda->total_penalty ?? '') }}" required>
        </div>
    </div>
</div>
