@extends('layouts.admin.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Dokumen</h4>
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
                        <a href="{{ route('documents.index') }}">Document</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Document</th>
                                <th>Status</th>
                                @if (Auth::user()->role_id == 1)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">No data available</td>
                                </tr>
                            @else
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            @if ($user->document)
                                                <a href="{{ asset('storage/' . $user->document) }}" target="_blank">View
                                                    Document</a>
                                            @else
                                                No Document Uploaded
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->status)
                                                {{ $user->status }}
                                            @else
                                                No Status Available
                                            @endif
                                        </td>
                                        <td>
                                            @if (Auth::user()->role_id == 1)
                                                @if ($user->document)
                                                    <a href="{{ route('documents.show', $user->id) }}"
                                                        class="btn btn-sm btn-secondary">View</a>
                                                    <form action="{{ route('document.destroy', $brand->id) }}"
                                                        method="post" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                @else
                                                    No Document To Change
                                                @endif
                                            @endif
                                        </td>
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
