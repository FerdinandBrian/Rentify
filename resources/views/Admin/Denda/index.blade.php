@extends('layouts.Admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Denda</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('denda.index') }}">CRUD Denda</a></li>
                </ul>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Denda</h4>
                        @if(auth()->user()->role->name == 'admin')
                        <a href="{{ route('denda.create') }}" class="btn btn-primary btn-round ms-auto">
                            <i class="fa fa-plus"></i>
                            Tambah Denda
                        </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    <th class="text-end" style="width: 18%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dendas as $denda)
                                    <tr>
                                        <td>{{ $denda->type }}</td>
                                        <td>Rp {{ number_format($denda->total_penalty ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-end">
                                            <div class="form-button-action justify-content-end">
                                                @if(auth()->user()->role->name == 'admin')
                                                <a href="{{ route('denda.edit', $denda->id) }}" class="btn btn-link btn-primary btn-lg"
                                                    data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('denda.destroy', $denda->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-link btn-danger" type="submit"
                                                        data-bs-toggle="tooltip" title="Hapus"
                                                        onclick="return confirm('Hapus denda ini?')">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-5">Belum ada data denda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $dendas->firstItem() ?? 0 }} - {{ $dendas->lastItem() ?? 0 }}
                            dari {{ $dendas->total() }} denda
                        </small>
                        {{ $dendas->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
