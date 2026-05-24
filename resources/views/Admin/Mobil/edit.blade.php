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
            <div class="card-header">
                <h4 class="card-title">Edit Mobil</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.cars.update', $car->series_number) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="series_number" class="form-label">Plat Nomor</label>
                            <input type="text" class="form-control" value="{{ $car->series_number }}" readonly>
                            <small class="text-muted">Plat nomor tidak dapat diubah</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Mobil <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $car->name) }}" required>
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
                                    <option value="{{ $brand->id }}"
                                        {{ old('Brand_id', $car->brand_id) == $brand->id ? 'selected' : '' }}>
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
                                    value="{{ old('price', $car->price) }}" min="100000" required>
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
                                    <option value="{{ $type }}"
                                        {{ old('type', $car->type) == $type ? 'selected' : '' }}>
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
                                value="{{ old('year', optional($car->year)->format('Y')) }}" min="2000" max="{{ date('Y') }}">
                            @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="Tersedia" {{ old('status', $car->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Disewa" {{ old('status', $car->status) == 'Disewa' ? 'selected' : '' }}>Disewa</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="is_electric" id="is_electric" 
                            class="form-check-input" value="1" 
                            {{ old('is_electric', $car->is_electric) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_electric">
                            Mobil Listrik (EV)
                        </label>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Gambar Saat Ini</label>
                        @if($car->images->count() > 0)
                            <div class="row g-3">
                                @foreach($car->images as $image)
                                    <div class="col-md-4 col-lg-3">
                                        <div class="car-image-option">
                                            <span class="car-image-preview">
                                                <img src="{{ asset($image->image_path) }}" alt="{{ $car->name }}">
                                            </span>
                                            <span class="d-flex align-items-center justify-content-between gap-2 mt-2">
                                                <span class="d-flex align-items-center gap-2">
                                                    <input type="radio" name="primary_image_id" value="{{ $image->id }}"
                                                        {{ old('primary_image_id', optional($car->images->firstWhere('is_primary', true))->id) == $image->id ? 'checked' : '' }}>
                                                    Jadikan utama
                                                </span>
                                                <label class="btn btn-danger btn-sm mb-0 car-delete-photo">
                                                    <input type="checkbox" name="delete_image_ids[]" value="{{ $image->id }}" class="d-none">
                                                    <i class="fa fa-trash"></i>
                                                    <span>Hapus</span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('primary_image_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                            @error('delete_image_ids') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                            @error('delete_image_ids.*') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                        @else
                            <div class="alert alert-warning mb-0">
                                Belum ada gambar untuk mobil ini.
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="images" class="form-label">Tambah Gambar Baru</label>
                        <input type="file" name="images[]" id="images"
                            class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/webp" multiple>
                        <small class="text-muted">Bisa tambah sampai 5 gambar baru.</small>
                        @error('images') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        @error('images.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="make_uploaded_primary" id="make_uploaded_primary"
                            class="form-check-input" value="1" {{ old('make_uploaded_primary') ? 'checked' : '' }}>
                        <label class="form-check-label" for="make_uploaded_primary">
                            Jadikan gambar baru pertama sebagai gambar utama
                        </label>
                    </div>

                    <div class="card-action">
                        <button type="submit" class="btn btn-primary btn-round">
                            <i class="fa fa-save"></i> Perbarui
                        </button>
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-black btn-border btn-round ms-2">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extraCSS')
<style>
    .car-image-option {
        display: block;
        padding: 10px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        height: 100%;
    }

    .car-image-preview {
        display: block;
        position: relative;
    }

    .car-image-option img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 6px;
        background: #f1f3f5;
    }

    .car-delete-photo {
        color: #fff;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .car-delete-photo.is-marked {
        background: #495057;
        border-color: #495057;
    }
</style>
@endsection

@section('extraJS')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.car-delete-photo input[type="checkbox"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const button = checkbox.closest('.car-delete-photo');
                const card = checkbox.closest('.car-image-option');
                const icon = button.querySelector('i');
                const label = button.querySelector('span');

                button.classList.toggle('is-marked', checkbox.checked);
                icon.className = checkbox.checked ? 'fa fa-undo' : 'fa fa-trash';
                label.textContent = checkbox.checked ? 'Batal' : 'Hapus';
                card.style.opacity = checkbox.checked ? '.55' : '1';
            });
        });
    });
</script>
@endsection
