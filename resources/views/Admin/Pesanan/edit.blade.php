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
                <form action="{{ route('orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <div class="card-title">Form Edit Pesanan {{ $order->id }}</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama Pelanggan</label>
                                    <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $order->name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="call_number">Nomor Telepon</label>
                                    <input id="call_number" type="text" name="call_number" class="form-control" value="{{ old('call_number', $order->call_number) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $order->email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-select" required>
                                        @foreach (['menunggu', 'aktif', 'selesai', 'dibatalkan'] as $status)
                                            <option value="{{ $status }}" @selected(old('status', $order->status) === $status)>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_rent">Tanggal Mulai</label>
                                    <input id="start_rent" type="datetime-local" name="start_rent" class="form-control"
                                        value="{{ old('start_rent', $order->start_rent?->format('Y-m-d\TH:i')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_rent">Tanggal Selesai</label>
                                    <input id="end_rent" type="datetime-local" name="end_rent" class="form-control"
                                        value="{{ old('end_rent', $order->end_rent?->format('Y-m-d\TH:i')) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action text-end">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-danger">Batal</a>
                        <button class="btn btn-success" type="submit">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
