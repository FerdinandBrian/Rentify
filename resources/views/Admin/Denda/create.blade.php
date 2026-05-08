@extends('layouts.Admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Tambah Denda</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('denda.index') }}">Denda</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="#">Tambah</a></li>
                </ul>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="card">
                <form action="{{ route('denda.store') }}" method="POST">
                    @csrf
                    <div class="card-header">
                        <div class="card-title">Form Denda</div>
                    </div>
                    <div class="card-body">
                        @include('Admin.Denda.partials.form', [
                            'denda' => null,
                            'formOptions' => $formOptions,
                        ])
                    </div>
                    <div class="card-action text-end">
                        <a href="{{ route('denda.index') }}" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('extraJS')
    @include('Admin.Denda.partials.payment-filter-script')
@endsection
