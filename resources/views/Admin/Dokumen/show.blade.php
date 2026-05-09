@extends('layouts.admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Review Dokumen</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('documents.index') }}">Dokumen</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><span>Review Pelanggan</span></li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail Dokumen: {{ $user->name }}</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="fw-bold">Informasi Pelanggan</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">Nama</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Status Saat Ini</th>
                                    <td>
                                        @if ($user->status === 'Verified')
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @elseif($user->status === 'Rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Menunggu Review</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <div class="mt-4">
                                <h5 class="fw-bold">Aksi Verifikasi</h5>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('document.changeStatus', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Verified">
                                        <button type="submit" class="btn btn-success btn-round">
                                            <i class="fa fa-check"></i> Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('document.changeStatus', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Rejected">
                                        <button type="submit" class="btn btn-danger btn-round">
                                            <i class="fa fa-times"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                                <a href="{{ route('documents.index') }}" class="btn btn-link mt-3 text-muted">
                                    <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="fw-bold">Pratinjau Dokumen</h5>
                            <div class="border rounded p-2 bg-light text-center">
                                @if($user->document)
                                    <img src="{{ asset('storage/' . $user->document) }}" alt="Dokumen Pelanggan"
                                        class="img-fluid rounded shadow-sm" style="max-height: 600px;">
                                @else
                                    <div class="py-5 text-muted">
                                        <i class="fa fa-file-excel fa-4x mb-3"></i>
                                        <p>Tidak ada file dokumen untuk ditampilkan.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
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
