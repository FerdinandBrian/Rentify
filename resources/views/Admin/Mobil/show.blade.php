@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Detail Mobil</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('admin.cars.index') }}">Mobil</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><span>Detail</span></li>
            </ul>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Plat Nomor</th>
                        <td>{{ $car->series_number }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $car->name }}</td>
                    </tr>
                    <tr>
                        <th>Merek</th>
                        <td>{{ $car->brand->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Harga per Hari</th>
                        <td>Rp{{ number_format($car->price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tipe</th>
                        <td>{{ $car->type }}</td>
                    </tr>
                    <tr>
                        <th>Tahun</th>
                        <td>{{ $car->year ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge {{ $car->status === 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                                {{ $car->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Transmisi</th>
                        <td>{{ $car->transmission ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kapasitas</th>
                        <td>{{ $car->capacity ?? '-' }}</td>
                    </tr>
                </table>

                <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ route('admin.cars.edit', $car->series_number) }}" class="btn btn-warning">
                    <i class="icon-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection