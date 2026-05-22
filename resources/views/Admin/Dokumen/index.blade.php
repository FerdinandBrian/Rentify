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

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
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
                                    <th style="width: 5%">#</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Jumlah Dokumen</th>
                                    <th>Status Ringkasan</th>
                                    <th class="text-end" style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    @php
                                        $docs = $user->documents;
                                        $pendingCount  = $docs->where('status', 'pending')->count();
                                        $approvedCount = $docs->where('status', 'approved')->count();
                                        $rejectedCount = $docs->where('status', 'rejected')->count();
                                    @endphp
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td class="fw-bold">{{ $user->name }}</td>
                                        <td>
                                            @if($docs->count() > 0)
                                                <span class="badge bg-secondary me-1">{{ $docs->count() }} total</span>
                                                @if($approvedCount) <span class="badge bg-success me-1">{{ $approvedCount }} approved</span> @endif
                                                @if($pendingCount)  <span class="badge bg-warning text-dark me-1">{{ $pendingCount }} pending</span> @endif
                                                @if($rejectedCount) <span class="badge bg-danger me-1">{{ $rejectedCount }} ditolak</span> @endif
                                            @else
                                                <span class="text-muted">Belum ada dokumen</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($docs->count() === 0)
                                                <span class="text-muted">-</span>
                                            @elseif($pendingCount > 0)
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fa fa-clock me-1"></i>Ada yang Pending
                                                </span>
                                            @elseif($approvedCount > 0 && $rejectedCount === 0)
                                                <span class="badge bg-success">
                                                    <i class="fa fa-check me-1"></i>Semua Terverifikasi
                                                </span>
                                            @elseif($rejectedCount > 0)
                                                <span class="badge bg-danger">
                                                    <i class="fa fa-times me-1"></i>Ada yang Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="form-button-action justify-content-end">
                                                @if ($docs->count() > 0)
                                                    <a href="{{ route('documents.show', $user->id) }}"
                                                        class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="Review Dokumen">
                                                        <i class="fa fa-check-square"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted small">Tidak ada dokumen</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">Belum ada pelanggan dengan dokumen untuk diverifikasi.</td>
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
