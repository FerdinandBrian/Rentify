@extends('layouts.Admin.master')

@section('title', 'Profile Admin - Rentify')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Profile Admin</h4>
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
                    <span>Profile</span>
                </li>
            </ul>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> Profil berhasil diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> Password berhasil diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any() && !session('status'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Silakan periksa kembali input Anda.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-4">
                <div class="card card-round">
                    <div class="card-body text-center py-4">
                        <div class="avatar-lg mx-auto mb-3">
                            <img src="{{ asset('assets/img/profile.jpg') }}" alt="Profile" class="rounded-circle">
                        </div>
                        <h4 class="fw-bold">{{ Auth::user()->name }}</h4>
                        <p class="text-muted mb-2">{{ Auth::user()->role_id == 1 ? 'Super Admin' : 'Admin/Pegawai' }}</p>
                        <span class="badge bg-primary px-3 py-2 rounded-pill">Active</span>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-title">Informasi Profil</div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                                       value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                                       value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card card-round mt-4">
                    <div class="card-header">
                        <div class="card-title">Perbarui Password</div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="update_password_current_password" class="form-label">Password Saat Ini</label>
                                <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" id="update_password_current_password" name="current_password" required>
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="update_password_password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" id="update_password_password" name="password" required>
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="update_password_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" id="update_password_password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-warning text-dark">
                                    <i class="fas fa-key me-2"></i>Ganti Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card card-round mt-4 border-danger">
                    <div class="card-header border-danger bg-transparent">
                        <div class="card-title text-danger">Hapus Akun</div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Setelah akun Anda dihapus, semua data dan sumber daya yang terkait akan dihapus secara permanen.</p>
                        
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                <i class="fas fa-trash me-2"></i>Hapus Akun
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Akun -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteAccountModalLabel">Apakah Anda yakin ingin menghapus akun?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun ini secara permanen.</p>
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" id="delete_password" name="password" placeholder="Password" required>
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Akun Permanen</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('extraJS')
<script>
    $(document).ready(function() {
        @if ($errors->userDeletion->isNotEmpty())
            var myModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
            myModal.show();
        @endif
    });
</script>
@endsection

@section('extraCSS')
    <style>
        .avatar-lg {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #f97316;
        }
        
        .avatar-lg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .page-inner {
            padding: 20px;
        }
        
        .card {
            margin-bottom: 24px;
        }
        
        .card-body {
            padding: 20px;
        }
    </style>
@endsection
