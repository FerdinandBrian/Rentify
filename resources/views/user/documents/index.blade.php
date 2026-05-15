@extends('layouts.User.master')

@section('title', 'Autentikasi Dokumen - Rentify')

@section('content')
    @php
        $pendingCount = $documents->where('status', 'pending')->count();
        $approvedCount = $documents->where('status', 'approved')->count();
        $rejectedCount = $documents->where('status', 'rejected')->count();
        $totalCount = $documents->count();
        $progress = $totalCount > 0 ? round(($approvedCount / $totalCount) * 100) : 0;
        $requiredDocuments = [
            'KTP' => ['icon' => 'fas fa-id-card', 'label' => 'Kartu Tanda Penduduk', 'required' => 'Wajib'],
            'SIM' => ['icon' => 'fas fa-id-badge', 'label' => 'Surat Izin Mengemudi', 'required' => 'Wajib'],
            'STNK' => ['icon' => 'fas fa-file-alt', 'label' => 'Dokumen kendaraan pendukung', 'required' => 'Opsional'],
            'Paspor' => ['icon' => 'fas fa-passport', 'label' => 'Untuk penyewa WNA', 'required' => 'Opsional'],
        ];
        $statusTone = [
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
        ];
    @endphp

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Autentikasi Dokumen</h4>
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
                        <a href="{{ route('user.documents') }}">Dokumen</a>
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
                <div class="col-lg-4">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">Status Verifikasi</div>
                        </div>
                        <div class="card-body text-center">
                            <div class="progress-circle" style="--progress: {{ $progress * 3.6 }}deg">
                                <div class="progress-circle-inner">
                                    <span>{{ $progress }}%</span>
                                </div>
                            </div>
                            <h5 class="mt-3 mb-1">{{ $approvedCount }} dari {{ $totalCount }} dokumen valid</h5>
                            <p class="text-muted mb-0">
                                {{ $pendingCount }} menunggu, {{ $rejectedCount }} ditolak
                            </p>
                        </div>
                    </div>

                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">Checklist Dokumen</div>
                        </div>
                        <div class="card-body">
                            @foreach($requiredDocuments as $type => $meta)
                                @php
                                    $document = $documents->firstWhere('document_type', $type);
                                @endphp
                                <div class="doc-check-item">
                                    <div class="doc-check-icon">
                                        <i class="{{ $meta['icon'] }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $type }}</h6>
                                        <small class="text-muted">{{ $meta['label'] }}</small>
                                    </div>
                                    @if($document)
                                        <span class="badge badge-{{ $statusTone[$document->status] ?? 'secondary' }}">
                                            {{ ucfirst($document->status) }}
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">{{ $meta['required'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div>
                                    <div class="card-title">Daftar Dokumen</div>
                                    <p class="card-category">Semua data diambil dari tabel documents milik akun Anda.</p>
                                </div>
                                <div class="card-tools">
                                    <a href="{{ route('user.documents.create') }}" class="btn btn-primary btn-round btn-sm">
                                        <i class="fas fa-plus me-2"></i>Upload Dokumen
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @forelse($documents as $document)
                                <div class="document-item">
                                    <div class="document-icon">
                                        <i class="{{ $requiredDocuments[$document->document_type]['icon'] ?? 'fas fa-file' }}"></i>
                                    </div>
                                    <div class="document-info">
                                        <div class="d-flex justify-content-between gap-2 flex-wrap">
                                            <div>
                                                <h6 class="mb-1">{{ $document->document_type }}</h6>
                                                <p class="text-muted mb-1">{{ $document->description ?: 'Tidak ada catatan tambahan' }}</p>
                                                <small class="text-muted">
                                                    Diunggah {{ optional($document->created_at)->format('d M Y H:i') }}
                                                </small>
                                            </div>
                                            <span class="badge badge-{{ $statusTone[$document->status] ?? 'secondary' }}">
                                                {{ ucfirst($document->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="document-actions">
                                        <div class="btn-group">
                                            <a href="{{ route('user.documents.show', $document->id) }}"
                                                class="btn btn-sm btn-primary" title="Lihat detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($document->status === 'pending')
                                                <a href="{{ route('user.documents.edit', $document->id) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('user.documents.destroy', $document->id) }}"
                                                    onsubmit="return confirm('Hapus dokumen ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('user.documents.download', $document->id) }}"
                                                class="btn btn-sm btn-info" title="Unduh">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="rentify-empty">
                                    <i class="fas fa-file-upload fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada dokumen</h5>
                                    <p class="text-muted">Upload KTP dan SIM agar proses rental lebih cepat diverifikasi admin.</p>
                                    <a href="{{ route('user.documents.create') }}" class="btn btn-primary btn-round">
                                        Upload Dokumen Pertama
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
    <style>
        .progress-circle {
            width: 126px;
            height: 126px;
            display: grid;
            place-items: center;
            margin: 0 auto;
            border-radius: 50%;
            background: conic-gradient(#1572e8 0deg, #1572e8 var(--progress), #e9ecef var(--progress));
        }

        .progress-circle-inner {
            width: 98px;
            height: 98px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #fff;
            color: #1572e8;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .doc-check-item,
        .document-item {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .doc-check-item {
            padding: 12px 0;
            border-bottom: 1px solid #eef1f5;
        }

        .doc-check-item:last-child,
        .document-item:last-child {
            border-bottom: 0;
        }

        .doc-check-icon,
        .document-icon {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: #f1f5fb;
            color: #1572e8;
            flex: 0 0 auto;
        }

        .document-item {
            padding: 16px 0;
            border-bottom: 1px solid #eef1f5;
        }

        .document-info {
            flex: 1;
            min-width: 0;
        }

        .document-actions form {
            display: inline-flex;
        }

        @media (max-width: 575.98px) {
            .document-item {
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .document-actions {
                width: 100%;
                padding-left: 60px;
            }
        }
    </style>
@endsection
