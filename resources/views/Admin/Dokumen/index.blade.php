@extends('layouts.admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Verifikasi Dokumen</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><span>Dokumen Pelanggan</span></li>
                </ul>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Dokumen Pelanggan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 10%">ID</th>
                                    <th>Nama Pelanggan</th>
                                    <th>File Dokumen</th>
                                    <th>Status</th>
                                    <th class="text-end" style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($documents as $document)
                                    <tr>
                                        <td>{{ $document->id }}</td>
                                        <td class="fw-bold">
                                            {{ $document->user->name ?? 'Customer tidak ditemukan' }}
                                            <div class="text-muted small">{{ $document->user->email ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-xs btn-outline-primary">
                                                <i class="fa fa-file"></i> {{ $document->document_type }}
                                            </a>
                                            <div class="text-muted small">{{ basename($document->file_path) }}</div>
                                        </td>
                                        <td>
                                            @if ($document->status === 'approved')
                                                <span class="badge bg-success">Terverifikasi</span>
                                            @elseif($document->status === 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif($document->status === 'pending')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="form-button-action justify-content-end">
                                                <a href="{{ route('documents.show', $document->id) }}"
                                                    class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="Review">
                                                    <i class="fa fa-check-square"></i>
                                                </a>
                                                @if(auth()->user()->role->name == 'admin')
                                                <form action="{{ route('document.destroy', $document->id) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-danger"
                                                        data-bs-toggle="tooltip" title="Hapus"
                                                        onclick="return confirm('Hapus dokumen ini?')">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">Belum ada data pelanggan untuk diverifikasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
@endsection


@section('extraJS')
@endsection
