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
                </ul>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">List Tipe Mobil</h3>
                    <a href="{{ route('brands.create') }}" class="btn btn-primary" role="button">Tambah Tipe Mobil</a>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                @if (Auth::user()->role_id == 1)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if ($brands->isEmpty())
                                <tr>
                                    <td colspan="3" class="text-center">No data available</td>
                                </tr>
                            @else
                                @foreach ($brands as $brand)
                                    <tr>
                                        <td>{{ $brand->id }}</td>
                                        <td>{{ $brand->name }}</td>
                                        @if (Auth::user()->role_id == 1)
                                            <td>
                                                <a href="{{ route('brands.edit', $brand->id) }}"
                                                    class="btn btn-sm btn-secondary">Edit</a>
                                                <form action="{{ route('brands.destroy', $brand->id) }}" method="post"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
@endsection


@section('extraJS')
@endsection
