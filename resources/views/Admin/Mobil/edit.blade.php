@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Edit Mobil</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('admin.cars.index') }}">Mobil</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><span>Edit</span></li>
            </ul>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.cars.update', $car->series_number) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Plat Nomor (readonly) --}}
                    <div class="mb-3">
                        <label for="series_number" class="form-label">Plat Nomor</label>
                        <input type="text" class="form-control" value="{{ $car->series_number }}" readonly>
                        <small class="text-muted">Plat nomor tidak dapat diubah</small>
                    </div>

                    {{-- Nama Mobil --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Mobil <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $car->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Merek --}}
                    <div class="mb-3">
                        <label for="Brand_id" class="form-label">Merek <span class="text-danger">*</span></label>
                        <select name="Brand_id" id="Brand_id"
                            class="form-select @error('Brand_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Merek --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('Brand_id', $car->Brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('Brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Harga per Hari --}}
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga per Hari <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="price"
                            class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price', $car->price) }}" min="100000" required>
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Tipe Mobil (dari database) --}}
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipe <span class="text-danger">*</span></label>
                        <select name="type" id="type"
                            class="form-select @error('type') is-invalid @enderror" required>
                            <option value="">-- Pilih Tipe --</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}"
                                    {{ old('type', $car->type) == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Tahun --}}
                    <div class="mb-3">
                        <label for="year" class="form-label">Tahun</label>
                        <input type="number" name="year" id="year"
                            class="form-control @error('year') is-invalid @enderror"
                            value="{{ old('year', $car->year) }}" min="2000" max="{{ date('Y') }}">
                        @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status"
                            class="form-select @error('status') is-invalid @enderror" required>
                            <option value="Tersedia" {{ old('status', $car->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Disewa" {{ old('status', $car->status) == 'Disewa' ? 'selected' : '' }}>Disewa</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="icon-check"></i> Perbarui
                    </button>
                    <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection