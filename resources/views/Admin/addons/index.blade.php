@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Daftar AddOn</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><span>AddOn</span></li>
            </ul>
        </div>

        <div class="mb-3">
            <a href="{{ route('admin.addons.create') }}" class="btn btn-primary">
                <i class="icon-plus"></i> Tambah AddOn Baru
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Harga per Unit</th>
                                <th>Harga per Hari</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($addons as $addon)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $addon->name }}</td>
                                    <td>Rp{{ number_format($addon->price_per_unit, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($addon->price_per_day, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('admin.addons.show', $addon->id) }}"
                                            class="btn btn-sm btn-info" title="Detail"><i class="icon-eye"></i></a>
                                        <a href="{{ route('admin.addons.edit', $addon->id) }}"
                                            class="btn btn-sm btn-warning" title="Edit"><i class="icon-pencil"></i></a>
                                        <form action="{{ route('admin.addons.destroy', $addon->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus addon ini?')" title="Hapus">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data AddOn.</td>
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