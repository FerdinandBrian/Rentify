@extends('layouts.Admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Edit Denda</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('denda.index') }}">Denda</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="#">Edit</a></li>
                </ul>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="card">
                <form action="{{ route('denda.update', $denda->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <div class="card-title">Form Edit Denda #{{ $denda->id }}</div>
                    </div>
                    <div class="card-body">
                        @include('Admin.Denda.partials.form', [
                            'denda' => $denda,
                            'formOptions' => $formOptions,
                        ])
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-primary"><i class="icon-check"></i> Perbarui</button>
                    <a href="{{ route('admin.addons.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('extraJS')
    @include('Admin.Denda.partials.payment-filter-script')
@endsection
