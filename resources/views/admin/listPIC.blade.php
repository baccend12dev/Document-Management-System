@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-users me-2"></i>Daftar PIC (Person in Charge)
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Tombol Tambah PIC -->
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPicModal">
                                <i class="fas fa-plus me-1"></i>Tambah PIC
                            </button>
                        </div>
                        <div>
                            <!-- Form Pencarian atau Filter Bisa Ditambahkan Di Sini -->
                        </div>
                    </div>

                    <!-- Tabel Daftar PIC -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama PIC</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Departments</th>
                                    <th scope="col">Section</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pics as $pic)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $pic->name }}</td>
                                    <td>{{ $pic->email }}</td>
                                    <td>{{ $pic->department }}</td>
                                    <td>{{ $pic->section }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('pic.delete', $pic->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus PIC ini?')">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada PIC ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah PIC -->
<!-- Modal Tambah PIC -->
<div class="modal fade" id="addPicModal" tabindex="-1" aria-labelledby="addPicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPicModalLabel">Tambah PIC Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pic.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pic_name" class="form-label">Nama PIC</label>
                                <input type="text" class="form-control" id="pic_name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pic_email" class="form-label">Email PIC</label>
                                <input type="email" class="form-control" id="pic_email" name="email" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pic_department" class="form-label">Departemen</label>
                                <select class="form-select" id="pic_department" name="department" required>
                                    <option value="">Pilih Departemen</option>
                                    <option value="QA">Quality Assurance</option>
                                    <option value="QC">Quality Control</option>
                                    <option value="PR">Production</option>
                                    <option value="TM">Technical</option>
                                    <option value="LG">Logistics</option>
                                    <option value="RD">Research and Development</option>
                                    <option value="IT">Information Technology</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pic_section" class="form-label">Section</label>
                                <select class="form-select" id="pic_section" name="section" required>
                                    <option value="">Pilih Section</option>
                                    <option value="Equipment">Equipment</option>
                                    <option value="Utility">Utility</option>
                                    <option value="Room Qualification">Room Qualification</option>
                                    <option value="Computerized System">Computerized System</option>
                                    <option value="Process Mediafill">Process Mediafill</option>
                                    <option value="Cleaning Validation">Cleaning Validation</option>
                                    <option value="Analytical Method">Analytical Method</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">List Tool</label>
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-bordered table-hover" id="toolListTable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">
                                            <input type="checkbox" id="selectAllTools" class="form-check-input">
                                        </th>
                                        <th width="10%">No</th>
                                        <th width="30%">Nama Tool</th>
                                        <th width="25%">Kategori</th>
                                        <th width="30%">Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody id="toolListBody">
                                    <!-- Data akan diisi melalui AJAX berdasarkan department dan section -->
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Pilih Department dan Section untuk menampilkan list tool
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan PIC</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Function untuk load tools berdasarkan department dan section
    function loadTools() {
        var department = $('#pic_department').val();
        var section = $('#pic_section').val();
        
        // Cek apakah department dan section sudah dipilih
        if (department && section) {
            // Tampilkan loading
            $('#toolListBody').html(`
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        <i class="fas fa-spinner fa-spin"></i> Loading data...
                    </td>
                </tr>
            `);
            
            // AJAX request
            $.ajax({
                url: '/api/tools/filter', // Sesuaikan dengan route Anda
                method: 'GET',
                data: {
                    department: department,
                    section: section
                },
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        let html = '';
                        response.data.forEach((tool, index) => {
                            html += `
                                <tr>
                                    <td>
                                        <input type="checkbox" name="tools[]" value="${tool.id}" class="form-check-input tool-checkbox">
                                    </td>
                                    <td>${index + 1}</td>
                                    <td>${tool.name}</td>
                                    <td>${tool.category}</td>
                                    <td>${tool.description || '-'}</td>
                                </tr>
                            `;
                        });
                        $('#toolListBody').html(html);
                    } else {
                        $('#toolListBody').html(`
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Tidak ada tool untuk Department dan Section yang dipilih
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(xhr) {
                    $('#toolListBody').html(`
                        <tr>
                            <td colspan="5" class="text-center text-danger">
                                <i class="fas fa-exclamation-triangle"></i> Gagal memuat data
                            </td>
                        </tr>
                    `);
                }
            });
        } else {
            // Reset tabel jika salah satu belum dipilih
            $('#toolListBody').html(`
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Pilih Department dan Section untuk menampilkan list tool
                    </td>
                </tr>
            `);
        }
        
        // Reset checkbox select all
        $('#selectAllTools').prop('checked', false);
    }
    
    // Trigger load tools ketika department berubah
    $('#pic_department').on('change', function() {
        loadTools();
    });
    
    // Trigger load tools ketika section berubah
    $('#pic_section').on('change', function() {
        loadTools();
    });

    // Reset form ketika modal ditutup
    $('#addPicModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $('#toolListBody').html(`
            <tr>
                <td colspan="5" class="text-center text-muted">
                    Pilih Department dan Section untuk menampilkan list tool
                </td>
            </tr>
        `);
        $('#selectAllTools').prop('checked', false);
    });
});
</script>
@endsection
