@extends('layouts.Admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Edit Pesanan</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('orders.index') }}">Pesanan</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="#">Edit</a></li>
                </ul>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Edit Pesanan: {{ $order->id }}</h4>
                </div>
                <form action="{{ route('orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                                <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $order->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="call_number" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                <input id="call_number" type="text" name="call_number" class="form-control" value="{{ old('call_number', $order->call_number) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $order->email) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select id="status" name="status" class="form-select" required>
                                    @foreach (['menunggu', 'aktif', 'selesai', 'dibatalkan'] as $status)
                                        <option value="{{ $status }}" @selected(old('status', $order->status) === $status)>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="start_rent" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input id="start_rent" type="datetime-local" name="start_rent" class="form-control"
                                    value="{{ old('start_rent', $order->start_rent?->format('Y-m-d\TH:i')) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_rent" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input id="end_rent" type="datetime-local" name="end_rent" class="form-control"
                                    value="{{ old('end_rent', $order->end_rent?->format('Y-m-d\TH:i')) }}" required>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-primary btn-round">
                                <i class="fa fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('orders.index') }}" class="btn btn-black btn-border btn-round ms-2">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
