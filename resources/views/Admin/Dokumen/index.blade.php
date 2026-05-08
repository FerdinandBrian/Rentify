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
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td class="fw-bold">{{ $user->name }}</td>
                                        <td>
                                            @if ($user->document)
                                                <a href="{{ asset('storage/' . $user->document) }}" target="_blank" class="btn btn-xs btn-outline-primary">
                                                    <i class="fa fa-file-pdf"></i> Lihat Dokumen
                                                </a>
                                            @else
                                                <span class="text-muted">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->status === 'Verified')
                                                <span class="badge bg-success">Terverifikasi</span>
                                            @elseif($user->status === 'Rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif($user->document)
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="form-button-action justify-content-end">
                                                @if ($user->document)
                                                    <a href="{{ route('documents.show', $user->id) }}"
                                                        class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="Review">
                                                        <i class="fa fa-check-square"></i>
                                                    </a>
                                                    <form action="{{ route('document.destroy', $user->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link btn-danger"
                                                            data-bs-toggle="tooltip" title="Hapus"
                                                            onclick="return confirm('Hapus dokumen ini?')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">Tidak ada aksi</span>
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
