@extends('layouts.User.master')

@section('title', 'Edit Dokumen - Rentify')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Edit Dokumen</h4>
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
                        <a href="{{ route('user.documents.index') }}">Dokumen</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <span>Edit</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">Perbarui Dokumen</div>
                            <p class="card-category">Hanya dokumen berstatus pending yang bisa diedit.</p>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.documents.update', $document->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label for="document_type" class="form-label">Jenis Dokumen</label>
                                    <select name="document_type" id="document_type" class="form-select @error('document_type') is-invalid @enderror" required>
                                        @foreach(['KTP', 'SIM', 'STNK', 'Paspor'] as $type)
                                            <option value="{{ $type }}" {{ old('document_type', $document->document_type) === $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('document_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="document_file" class="form-label">Ganti File Dokumen</label>
                                    <input type="file" name="document_file" id="document_file"
                                        class="form-control @error('document_file') is-invalid @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">Kosongkan jika ingin tetap memakai file lama.</small>
                                    @error('document_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea name="description" id="description" rows="3"
                                        class="form-control @error('description') is-invalid @enderror">{{ old('description', $document->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between gap-2">
                                    <a href="{{ route('user.documents.index') }}" class="btn btn-light">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">File Saat Ini</div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="file-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ basename($document->file_path) }}</h6>
                                    <p class="text-muted mb-0">{{ ucfirst($document->status) }}</p>
                                </div>
                            </div>
                            <a href="{{ route('user.documents.download', $document->id) }}" class="btn btn-outline-primary w-100 mt-3">
                                <i class="fas fa-download me-2"></i>Unduh File Lama
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
    <style>
        .file-icon {
            width: 52px;
            height: 52px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: #f1f5fb;
            color: #1572e8;
            font-size: 1.4rem;
            flex: 0 0 auto;
        }
    </style>
@endsection
