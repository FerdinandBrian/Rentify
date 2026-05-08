@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="page-inner">
        {{-- Breadcrumbs --}}
        <div class="page-header">
            <h4 class="page-title">Daftar Mobil</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Mobil</span>
                </li>
            </ul>
        </div>

        {{-- Tombol Tambah --}}
        <div class="mb-3">
            <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">
                <i class="icon-plus"></i> Tambah Mobil Baru
            </a>
        </div>

        {{-- Tabel Daftar Mobil --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Plat Nomor</th>
                                <th>Nama</th>
                                <th>Merek</th>
                                <th>Harga/Hari</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cars as $car)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $car->series_number }}</td>
                                    <td>{{ $car->name }}</td>
                                    <td>{{ $car->brand->name ?? '-' }}</td>
                                    <td>Rp{{ number_format($car->price, 0, ',', '.') }}</td>
                                    <td>{{ $car->type }}</td>
                                    <td>
                                        <span class="badge {{ $car->status === 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $car->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.cars.show', $car->series_number) }}"
                                            class="btn btn-sm btn-info" title="Detail">
                                            <i class="icon-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.cars.edit', $car->series_number) }}"
                                            class="btn btn-sm btn-warning" title="Edit">
                                            <i class="icon-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.cars.destroy', $car->series_number) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus mobil ini?')" title="Hapus">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada data mobil.</td>
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