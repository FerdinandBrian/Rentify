@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Tambah Mobil Baru</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('admin.cars.index') }}">Mobil</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><span>Tambah</span></li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Mobil Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.cars.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="series_number" class="form-label">Plat Nomor <span class="text-danger">*</span></label>
                            <input type="text" name="series_number" id="series_number"
                                class="form-control @error('series_number') is-invalid @enderror"
                                value="{{ old('series_number') }}" placeholder="Contoh: B 1234 ABC" required>
                            @error('series_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Mobil <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Nama model mobil..." required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="Brand_id" class="form-label">Merek <span class="text-danger">*</span></label>
                            <select name="Brand_id" id="Brand_id"
                                class="form-select @error('Brand_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Merek --</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('Brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('Brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga Sewa / Hari <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" id="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}" min="100000" required>
                            </div>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="type" class="form-label">Tipe <span class="text-danger">*</span></label>
                            <select name="type" id="type"
                                class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">-- Pilih Tipe --</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="year" class="form-label">Tahun</label>
                            <input type="number" name="year" id="year"
                                class="form-control @error('year') is-invalid @enderror"
                                value="{{ old('year') }}" min="2000" max="{{ date('Y') }}">
                            @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Disewa" {{ old('status') == 'Disewa' ? 'selected' : '' }}>Disewa</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="is_electric" id="is_electric" 
                            class="form-check-input" value="1" {{ old('is_electric') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_electric">
                            Mobil Listrik (EV)
                        </label>
                    </div>

                    <div class="card-action">
                        <button type="submit" class="btn btn-primary btn-round">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-black btn-border btn-round ms-2">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection