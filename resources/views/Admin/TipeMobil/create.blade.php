@extends('layouts.admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Tambah Merek</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('brands.index') }}">Merek</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><span>Tambah</span></li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Merek Baru</h4>
                </div>

                <div class="card-body">
                    <form method="post" action="{{ route('brands.store') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">Nama Merek <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" maxlength="60"
                                placeholder="Masukkan nama merek..." autofocus required>
                        </div>
                        
                        <div class="card-action">
                            <button type="submit" class="btn btn-primary btn-round">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('brands.index') }}" class="btn btn-black btn-border btn-round ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
@endsection


@section('extraJS')
@endsection
