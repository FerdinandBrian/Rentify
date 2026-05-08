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
                        <a href="{{ route('document.index') }}">Document</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Document {{ $user->id }}</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">Document {{ $user->id }}</h3>
                </div>

                <div class="card-body">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Document:</strong>

                        <img src="{{ asset('storage/' . $user->document) }}" alt="Document"
                            style="max-width: 100%; height: auto;">

                    </p>
                    <p><strong>Status:</strong>
                        @if ($user->status == 1)
                            <div class="badge badge-success">Approved</div>
                        @elseif ($user->status == 0)
                            <div class="badge badge-danger">Rejected</div>
                        @elseif ($user->status == 2)
                            <div class="badge badge-warning">Pending</div>
                        @endif
                    </p>

                    @if ($user->status == 2)
                        <form action="{{ route('document.changestatus', $user->id) }}" class="form-inline">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Approved</option>
                                    <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
@endsection


@section('extraJS')
@endsection
