@extends('layouts.User.master')

@section('title', 'Upload Dokumen - Rentify')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Upload Dokumen</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('user.dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.documents') }}">Dokumen</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <span>Upload</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">Upload Dokumen Verifikasi</div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.documents.store') }}" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="mb-4">
                                    <label for="document_type" class="form-label">Jenis Dokumen <span class="text-danger">*</span></label>
                                    <select name="document_type" id="document_type" class="form-select" required>
                                        <option value="">Pilih jenis dokumen</option>
                                        <option value="KTP" {{ old('document_type') == 'KTP' ? 'selected' : '' }}>KTP (Kartu Tanda Penduduk)</option>
                                        <option value="SIM" {{ old('document_type') == 'SIM' ? 'selected' : '' }}>SIM (Surat Izin Mengemudi)</option>
                                        <option value="STNK" {{ old('document_type') == 'STNK' ? 'selected' : '' }}>STNK (Surat Tanda Nomor Kendaraan)</option>
                                        <option value="Paspor" {{ old('document_type') == 'Paspor' ? 'selected' : '' }}>Paspor</option>
                                    </select>
                                    @error('document_type')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="document_file" class="form-label">File Dokumen <span class="text-danger">*</span></label>
                                    <div class="file-upload-wrapper">
                                        <div class="file-upload-area" id="fileUploadArea">
                                            <div class="file-upload-content">
                                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                                <h5>Drag & Drop file di sini</h5>
                                                <p class="text-muted">atau klik untuk memilih file</p>
                                                <p class="text-muted small">Format: PDF, JPG, JPEG, PNG (Max: 2MB)</p>
                                            </div>
                                            <input type="file" name="document_file" id="document_file" class="file-upload-input" accept=".pdf,.jpg,.jpeg,.png" required>
                                        </div>
                                        <div class="file-preview d-none" id="filePreview">
                                            <div class="file-preview-content">
                                                <div class="file-preview-icon">
                                                    <i class="fas fa-file-alt fa-3x"></i>
                                                </div>
                                                <div class="file-preview-info">
                                                    <h6 id="fileName"></h6>
                                                    <p class="text-muted mb-0" id="fileSize"></p>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-danger" id="removeFile">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @error('document_file')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="form-label">Deskripsi (Opsional)</label>
                                    <textarea name="description" id="description" rows="3" class="form-control" 
                                              placeholder="Tambahkan deskripsi atau catatan tentang dokumen ini...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('user.documents') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload me-2"></i>Upload Dokumen
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Upload Guidelines -->
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-title">Panduan Upload</div>
                        </div>
                        <div class="card-body">
                            <div class="guidelines">
                                <div class="guideline-item">
                                    <div class="guideline-icon">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </div>
                                    <div class="guideline-text">
                                        <h6>Format File</h6>
                                        <p class="text-muted mb-0">PDF, JPG, JPEG, PNG</p>
                                    </div>
                                </div>
                                <div class="guideline-item">
                                    <div class="guideline-icon">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </div>
                                    <div class="guideline-text">
                                        <h6>Ukuran Maksimal</h6>
                                        <p class="text-muted mb-0">2MB per file</p>
                                    </div>
                                </div>
                                <div class="guideline-item">
                                    <div class="guideline-icon">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </div>
                                    <div class="guideline-text">
                                        <h6>Kualitas Gambar</h6>
                                        <p class="text-muted mb-0">Jelas dan mudah dibaca</p>
                                    </div>
                                </div>
                                <div class="guideline-item">
                                    <div class="guideline-icon">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </div>
                                    <div class="guideline-text">
                                        <h6>Informasi Valid</h6>
                                        <p class="text-muted mb-0">Pastikan data masih berlaku</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Required Documents -->
                    <div class="card card-round mt-4">
                        <div class="card-header">
                            <div class="card-title">Dokumen Wajib</div>
                        </div>
                        <div class="card-body">
                            <div class="required-docs">
                                <div class="required-doc">
                                    <div class="required-doc-icon">
                                        <i class="fas fa-id-card text-primary"></i>
                                    </div>
                                    <div class="required-doc-info">
                                        <h6>KTP</h6>
                                        <p class="text-muted mb-0">Wajib</p>
                                    </div>
                                </div>
                                <div class="required-doc">
                                    <div class="required-doc-icon">
                                        <i class="fas fa-id-badge text-success"></i>
                                    </div>
                                    <div class="required-doc-info">
                                        <h6>SIM</h6>
                                        <p class="text-muted mb-0">Wajib</p>
                                    </div>
                                </div>
                                <div class="required-doc">
                                    <div class="required-doc-icon">
                                        <i class="fas fa-file-alt text-warning"></i>
                                    </div>
                                    <div class="required-doc-info">
                                        <h6>STNK</h6>
                                        <p class="text-muted mb-0">Opsional</p>
                                    </div>
                                </div>
                                <div class="required-doc">
                                    <div class="required-doc-icon">
                                        <i class="fas fa-passport text-info"></i>
                                    </div>
                                    <div class="required-doc-info">
                                        <h6>Paspor</h6>
                                        <p class="text-muted mb-0">Opsional (WNA)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraCSS')
    <style>
        .file-upload-wrapper {
            position: relative;
        }
        
        .file-upload-area {
            border: 2px dashed #e9ecef;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload-area:hover {
            border-color: #5e72e4;
            background-color: #f8f9fa;
        }
        
        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        
        .file-preview {
            border: 2px solid #5e72e4;
            border-radius: 8px;
            padding: 1rem;
        }
        
        .file-preview-content {
            display: flex;
            align-items: center;
            position: relative;
        }
        
        .file-preview-icon {
            margin-right: 1rem;
            color: #5e72e4;
        }
        
        .file-preview-info {
            flex-grow: 1;
        }
        
        .file-preview-info h6 {
            margin-bottom: 0.25rem;
        }
        
        .file-preview #removeFile {
            position: absolute;
            top: 0;
            right: 0;
        }
        
        .guidelines .guideline-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .guideline-icon {
            margin-right: 1rem;
            font-size: 1.25rem;
        }
        
        .guideline-text h6 {
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }
        
        .guideline-text p {
            font-size: 0.75rem;
        }
        
        .required-docs .required-doc {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 8px;
            background: #f8f9fa;
        }
        
        .required-doc-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 50%;
            margin-right: 1rem;
            font-size: 1.25rem;
        }
        
        .required-doc-info h6 {
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }
        
        .required-doc-info p {
            font-size: 0.75rem;
        }
    </style>
@endsection

@section('extraJS')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileUploadArea = document.getElementById('fileUploadArea');
            const fileInput = document.getElementById('document_file');
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const removeFileBtn = document.getElementById('removeFile');
            
            // Handle file selection
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    showFilePreview(file);
                }
            });
            
            // Handle drag and drop
            fileUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                fileUploadArea.classList.add('dragover');
            });
            
            fileUploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                fileUploadArea.classList.remove('dragover');
            });
            
            fileUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                fileUploadArea.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    showFilePreview(files[0]);
                }
            });
            
            // Handle file removal
            removeFileBtn.addEventListener('click', function() {
                fileInput.value = '';
                filePreview.classList.add('d-none');
                fileUploadArea.classList.remove('d-none');
            });
            
            function showFilePreview(file) {
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                
                fileUploadArea.classList.add('d-none');
                filePreview.classList.remove('d-none');
            }
            
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        });
    </script>
@endsection
