@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Tambah AddOn Baru</h4>
            <ul class="breadcrumbs">
                <li class="nav-home"><a href="{{ route('dashboard') }}"><i class="icon-home"></i></a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="{{ route('admin.addons.index') }}">AddOn</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><span>Tambah</span></li>
            </ul>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.addons.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama AddOn <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price_per_unit" class="form-label">Harga per Unit</label>
                        <input type="number" name="price_per_unit" id="price_per_unit"
                            class="form-control @error('price_per_unit') is-invalid @enderror"
                            value="{{ old('price_per_unit') }}" min="0">
                        @error('price_per_unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price_per_day" class="form-label">Harga per Hari</label>
                        <input type="number" name="price_per_day" id="price_per_day"
                            class="form-control @error('price_per_day') is-invalid @enderror"
                            value="{{ old('price_per_day') }}" min="0">
                        @error('price_per_day') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-success"><i class="icon-check"></i> Simpan</button>
                    <a href="{{ route('admin.addons.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extraCSS')@endsection
@section('extraJS')@endsection