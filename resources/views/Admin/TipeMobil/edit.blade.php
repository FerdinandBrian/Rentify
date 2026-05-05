@extends('layouts.admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Dashboard</h4>
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
                        <a href="{{ route('brands.index') }}">Tipe Mobil</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Edit Tipe Mobil</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">Edit Tipe Mobil</h3>
                </div>

                <div class="card-body">
                    <form method="post" action="{{ route('brands.update', $brand->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" maxlength="60"
                                value="{{ old('name', $brand->name) }}" autofocus required>
                        </div>

                        <button type="submit" class="btn btn-primary">Edit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="button" class="btn btn-danger"
                            onclick="window.location.href='{{ route('brands.index') }}'">Cancel</button>
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
