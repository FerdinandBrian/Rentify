@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Mobil</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><span>Manajemen Mobil</span></li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Daftar Mobil</h4>
                    @if(auth()->user()->role->name == 'admin')
                    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary btn-round ms-auto">
                        <i class="fa fa-plus"></i>
                        Tambah Mobil
                    </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Plat Nomor</th>
                                <th>Nama</th>
                                <th>Merek</th>
                                <th>Harga/Hari</th>
                                <th>Tipe</th>
                                <th>Listrik</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cars as $car)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $car->series_number }}</td>
                                    <td>{{ $car->name }}</td>
                                    <td>{{ $car->brand->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($car->price, 0, ',', '.') }}</td>
                                    <td>{{ $car->type }}</td>
                                    <td class="text-center">
                                        @if($car->is_electric)
                                            <span class="badge bg-info"><i class="fa fa-bolt text-warning"></i> EV</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $car->status === 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $car->status }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="form-button-action justify-content-end">
                                            <a href="{{ route('admin.cars.show', $car->series_number) }}"
                                                class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if(auth()->user()->role->name == 'admin')
                                            <a href="{{ route('admin.cars.edit', $car->series_number) }}"
                                                class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.cars.destroy', $car->series_number) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link btn-danger"
                                                    data-bs-toggle="tooltip" title="Hapus"
                                                    onclick="return confirm('Yakin hapus mobil ini?')">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-5">Belum ada data mobil.</td>
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