@extends('layouts.User.master')

@section('title', 'Detail Dokumen - Rentify')

@section('content')
    @php
        $statusTone = [
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
        ];
        $documentMeta = [
            'KTP' => ['icon' => 'fas fa-id-card', 'label' => 'Kartu Tanda Penduduk'],
            'SIM' => ['icon' => 'fas fa-id-badge', 'label' => 'Surat Izin Mengemudi'],
            'STNK' => ['icon' => 'fas fa-file-alt', 'label' => 'Surat Tanda Nomor Kendaraan'],
            'Paspor' => ['icon' => 'fas fa-passport', 'label' => 'Paspor'],
        ];
        $extension = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));
        $isImage = in_array($extension, ['jpg', 'jpeg', 'png'], true);
    @endphp

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Detail Dokumen</h4>
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
                        <span>{{ $document->document_type }}</span>
                    </li>
                </ul>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div>
                                    <div class="card-title">Informasi Dokumen</div>
                                    <p class="card-category">Data dari tabel documents.</p>
                                </div>
                                <div class="card-tools">
                                    <span class="badge badge-{{ $statusTone[$document->status] ?? 'secondary' }} badge-lg">
                                        {{ ucfirst($document->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-row">
                                        <span>Jenis Dokumen</span>
                                        <strong>
                                            <i class="{{ $documentMeta[$document->document_type]['icon'] ?? 'fas fa-file' }} me-2"></i>
                                            {{ $documentMeta[$document->document_type]['label'] ?? $document->document_type }}
                                        </strong>
                                    </div>
                                    <div class="info-row">
                                        <span>Nama File</span>
                                        <strong>{{ basename($document->file_path) }}</strong>
                                    </div>
                                    <div class="info-row">
                                        <span>Catatan</span>
                                        <strong>{{ $document->description ?: 'Tidak ada catatan' }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-row">
                                        <span>Tanggal Upload</span>
                                        <strong>{{ optional($document->created_at)->format('d M Y H:i') }}</strong>
                                    </div>
                                    <div class="info-row">
                                        <span>Update Terakhir</span>
                                        <strong>{{ optional($document->updated_at)->format('d M Y H:i') }}</strong>
                                    </div>
                                    <div class="info-row">
                                        <span>Status Verifikasi</span>
                                        <strong>{{ ucfirst($document->status) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-round mt-4">
                        <div class="card-header">
                            <div class="card-title">Preview File</div>
                        </div>
                        <div class="card-body">
                            @if($isImage)
                                <img src="{{ asset('storage/' . $document->file_path) }}" alt="{{ $document->document_type }}"
                                    class="document-preview-img">
                            @else
                                <div class="document-preview-placeholder">
                                    <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                                    <h5>{{ basename($document->file_path) }}</h5>
                                    <p class="text-muted mb-0">Preview PDF tidak ditampilkan di sini. File bisa diunduh dari tombol aksi.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card card-round mt-4">
                        <div class="card-header">
                            <div class="card-title">Timeline Verifikasi</div>
                        </div>
                        <div class="card-body">
                            <div class="timeline-mini">
                                <div class="timeline-mini-item active">
                                    <span></span>
                                    <div>
                                        <strong>Dokumen diunggah</strong>
                                        <p class="text-muted mb-0">{{ optional($document->created_at)->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="timeline-mini-item {{ $document->status !== 'pending' ? 'active' : '' }}">
                                    <span></span>
                                    <div>
                                        <strong>{{ $document->status === 'pending' ? 'Menunggu verifikasi' : 'Status diperbarui' }}</strong>
                                        <p class="text-muted mb-0">
                                            {{ $document->status === 'pending' ? 'Belum ada keputusan admin.' : optional($document->updated_at)->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">Aksi Dokumen</div>
                        </div>
                        <div class="card-body rentify-action-list d-grid gap-2">
                            <a href="{{ route('user.documents.download', $document->id) }}" class="btn btn-primary">
                                <i class="fas fa-download me-2"></i>Unduh Dokumen
                            </a>
                            <a href="{{ route('user.documents.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                            </a>

                            @if($document->status === 'pending')
                                <a href="{{ route('user.documents.edit', $document->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Edit Dokumen
                                </a>
                                <form method="POST" action="{{ route('user.documents.destroy', $document->id) }}"
                                    onsubmit="return confirm('Hapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-trash me-2"></i>Hapus Dokumen
                                    </button>
                                </form>
                            @endif

                            @if($document->status === 'rejected')
                                <a href="{{ route('user.documents.create') }}" class="btn btn-info">
                                    <i class="fas fa-redo me-2"></i>Upload Dokumen Baru
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="card card-round mt-4">
                        <div class="card-header">
                            <div class="card-title">Status Saat Ini</div>
                        </div>
                        <div class="card-body">
                            <div class="status-box status-{{ $document->status }}">
                                <i class="{{ $documentMeta[$document->document_type]['icon'] ?? 'fas fa-file' }}"></i>
                                <div>
                                    <h6 class="mb-1">{{ ucfirst($document->status) }}</h6>
                                    <p class="mb-0 text-muted">
                                        @if($document->status === 'approved')
                                            Dokumen ini sudah disetujui admin.
                                        @elseif($document->status === 'rejected')
                                            Dokumen ini ditolak admin dan bisa diganti dengan upload baru.
                                        @else
                                            Dokumen ini masih menunggu verifikasi admin.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
    <style>
        .badge-lg {
            font-size: .95rem;
            padding: .45rem .85rem;
        }

        .info-row {
            padding: 12px 0;
            border-bottom: 1px solid #eef1f5;
        }

        .info-row span,
        .info-row strong {
            display: block;
        }

        .info-row span {
            color: #6c757d;
            font-size: .8rem;
            margin-bottom: 4px;
        }

        .document-preview-img {
            width: 100%;
            max-height: 560px;
            object-fit: contain;
            border-radius: 8px;
            background: #f8fafc;
        }

        .document-preview-placeholder {
            padding: 48px 16px;
            text-align: center;
            border-radius: 8px;
            background: #f8fafc;
        }

        .timeline-mini {
            display: grid;
            gap: 18px;
        }

        .timeline-mini-item {
            display: flex;
            gap: 12px;
            opacity: .55;
        }

        .timeline-mini-item.active {
            opacity: 1;
        }

        .timeline-mini-item > span {
            width: 12px;
            height: 12px;
            margin-top: 4px;
            border-radius: 50%;
            background: #ced4da;
            flex: 0 0 auto;
        }

        .timeline-mini-item.active > span {
            background: #1572e8;
        }

        .status-box {
            display: flex;
            gap: 14px;
            padding: 16px;
            border-radius: 8px;
            background: #f8fafc;
        }

        .status-box i {
            color: #1572e8;
            font-size: 1.5rem;
        }
    </style>
@endsection
