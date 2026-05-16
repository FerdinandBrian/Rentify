@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">AddOn</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><span>Manajemen AddOn</span></li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Daftar AddOn</h4>
                    @if(auth()->user()->role->name == 'admin')
                    <a href="{{ route('admin.addons.create') }}" class="btn btn-primary btn-round ms-auto">
                        <i class="fa fa-plus"></i>
                        Tambah AddOn
                    </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width: 10%">No</th>
                                <th>Nama AddOn</th>
                                <th>Harga / Unit</th>
                                <th>Harga / Hari</th>
                                <th class="text-end" style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($addons as $addon)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $addon->name }}</td>
                                    <td>Rp {{ number_format($addon->price_per_unit, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($addon->price_per_day, 0, ',', '.') }}</td>
                                    <td class="text-end">
                                        <div class="form-button-action justify-content-end">
                                            @if(auth()->user()->role->name == 'admin')
                                            <a href="{{ route('admin.addons.edit', $addon->id) }}"
                                                class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.addons.destroy', $addon->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link btn-danger"
                                                    data-bs-toggle="tooltip" title="Hapus"
                                                    onclick="return confirm('Yakin hapus addon ini?')">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">Belum ada data AddOn.</td>
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

@section('extraCSS')@endsection
@section('extraJS')@endsection