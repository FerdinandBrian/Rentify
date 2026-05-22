@extends('layouts.admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Review Dokumen Pelanggan</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('documents.index') }}">Dokumen</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><span>{{ $user->name }}</span></li>
                </ul>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            {{-- Informasi Pelanggan --}}
            <div class="card card-round mb-4">
                <div class="card-header">
                    <h4 class="card-title">Informasi Pelanggan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Nama</p>
                            <p class="fw-bold mb-0">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Email</p>
                            <p class="mb-0">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1 small fw-bold text-uppercase">No. Telepon</p>
                            <p class="mb-0">{{ $user->call_number ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daftar Dokumen --}}
            @forelse($user->documents->sortByDesc('created_at') as $document)
                @php
                    $ext = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));
                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png']);
                    $badgeColor = [
                        'pending'  => 'warning text-dark',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    ][$document->status] ?? 'secondary';
                    $typeLabel = [
                        'KTP'    => ['icon' => 'fa-id-card',   'label' => 'Kartu Tanda Penduduk'],
                        'SIM'    => ['icon' => 'fa-id-badge',  'label' => 'Surat Izin Mengemudi'],
                        'STNK'   => ['icon' => 'fa-file-alt',  'label' => 'Surat Tanda Nomor Kendaraan'],
                        'Paspor' => ['icon' => 'fa-passport',  'label' => 'Paspor'],
                    ][$document->document_type] ?? ['icon' => 'fa-file', 'label' => $document->document_type];
                @endphp

                <div class="card card-round mb-4">
                    <div class="card-header d-flex align-items-center gap-3">
                        <div class="doc-type-icon">
                            <i class="fa {{ $typeLabel['icon'] }}"></i>
                        </div>
                        <div>
                            <h4 class="card-title mb-0">{{ $document->document_type }}</h4>
                            <small class="text-muted">{{ $typeLabel['label'] }}</small>
                        </div>
                        <div class="ms-auto d-flex align-items-center gap-2">
                            <span class="badge bg-{{ $badgeColor }}">
                                {{ ucfirst($document->status) }}
                            </span>
                            <small class="text-muted">Diunggah: {{ optional($document->created_at)->format('d M Y H:i') }}</small>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                {{-- Preview --}}
                                <div class="border rounded p-2 bg-light text-center mb-3">
                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $document->file_path) }}"
                                            alt="{{ $document->document_type }}"
                                            class="img-fluid rounded shadow-sm" style="max-height: 400px; object-fit: contain;">
                                    @else
                                        <div class="py-4 text-muted">
                                            <i class="fa fa-file-pdf fa-4x mb-3 text-danger"></i>
                                            <p>File PDF — tidak bisa dipreview</p>
                                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-external-link-alt me-1"></i>Buka PDF
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                {{-- Catatan dari user --}}
                                @if($document->description)
                                    <div class="alert alert-light border">
                                        <strong>Catatan user:</strong><br>{{ $document->description }}
                                    </div>
                                @endif

                                {{-- Alasan penolakan jika ada --}}
                                @if($document->status === 'rejected' && $document->rejection_reason)
                                    <div class="alert alert-danger">
                                        <strong><i class="fa fa-times-circle me-1"></i>Alasan Penolakan:</strong><br>
                                        {{ $document->rejection_reason }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-7">
                                @if(auth()->user()->role->name == 'admin')
                                    <h5 class="fw-bold mb-3">Ubah Status Dokumen</h5>

                                    {{-- Form Setujui --}}
                                    @if($document->status !== 'approved')
                                        <form action="{{ route('document.changeStatus', $document->id) }}" method="POST" class="mb-3">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-success btn-round w-100"
                                                onclick="return confirm('Setujui dokumen {{ $document->document_type }} ini?')">
                                                <i class="fa fa-check me-2"></i>Setujui Dokumen Ini
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-success mb-3">
                                            <i class="fa fa-check-circle me-2"></i>Dokumen ini sudah disetujui.
                                        </div>
                                    @endif

                                    {{-- Form Tolak dengan alasan --}}
                                    @if($document->status !== 'rejected')
                                        <form action="{{ route('document.changeStatus', $document->id) }}" method="POST" class="mb-3">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Alasan Penolakan <span class="text-muted">(opsional)</span></label>
                                                <textarea name="rejection_reason" class="form-control" rows="3"
                                                    placeholder="Misal: Foto tidak jelas, dokumen sudah kadaluarsa, dll."></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-danger btn-round w-100"
                                                onclick="return confirm('Tolak dokumen {{ $document->document_type }} ini?')">
                                                <i class="fa fa-times me-2"></i>Tolak Dokumen Ini
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-danger mb-3">
                                            <i class="fa fa-times-circle me-2"></i>Dokumen ini sudah ditolak.
                                        </div>
                                    @endif

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('document.destroy', $document->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-round w-100"
                                            onclick="return confirm('Hapus permanen dokumen ini?')">
                                            <i class="fa fa-trash me-2"></i>Hapus Dokumen
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle me-2"></i>Hanya admin yang bisa mengubah status dokumen.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fa fa-folder-open fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Pelanggan ini belum mengunggah dokumen apapun.</h5>
                        <a href="{{ route('documents.index') }}" class="btn btn-primary btn-round mt-3">
                            <i class="fa fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            @endforelse

            <div class="mt-3">
                <a href="{{ route('documents.index') }}" class="btn btn-black btn-border btn-round">
                    <i class="fa fa-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
<style>
    .doc-type-icon {
        width: 44px;
        height: 44px;
        display: grid;
        place-items: center;
        border-radius: 8px;
        background: #f1f5fb;
        color: #1572e8;
        flex: 0 0 auto;
        font-size: 1.2rem;
    }
</style>
@endsection

@section('extraJS')
@endsection
