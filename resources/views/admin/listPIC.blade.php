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
                            <form action="{{ route('admin.list-pic') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Nama PIC / No Dokumen..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">Cari</button>
                            </form>
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
                                <tr data-toggle="collapse" data-target="#collapseDocs{{ $pic->id }}" aria-expanded="false" aria-controls="collapseDocs{{ $pic->id }}" style="cursor: pointer;">
                                    <th scope="row">
                                        <i class="fas fa-chevron-down text-muted me-1"></i>
                                        {{ $loop->iteration }}
                                    </th>
                                    <td>{{ $pic->name }}</td>
                                    <td>{{ $pic->email }}</td>
                                    <td>{{ $pic->department }}</td>
                                    <td>{{ $pic->section }}</td>
                                    <td>
                                        <a href="{{ route('pic.add-document', $pic->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Tambah Dokumen">
                                            <i class="fas fa-plus"></i>
                                        </a>
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
                                <!-- Nested Table for Documents -->
                                <tr id="collapseDocs{{ $pic->id }}" class="collapse bg-light">
                                    <td colspan="6" class="p-3">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">No Dokumen</th>
                                                        <th scope="col">Tipe Dokumen</th>
                                                        <th scope="col">Next Review Date</th>
                                                        <th scope="col">Kategori</th>
                                                        <th scope="col">CC PIC</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($pic->picDocuments as $picDoc)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>{{ $picDoc->document ? $picDoc->document->doc_number : 'N/A' }}</td>
                                                        <td>{{ $picDoc->document ? $picDoc->document->document_type : 'N/A' }}</td>
                                                        <td>{{ $picDoc->document ? $picDoc->document->next_review : 'N/A' }}</td>
                                                        <td>{{ $picDoc->document ? $picDoc->document->sub_menu : 'N/A' }}</td>
                                                        <td>{{ $picDoc->ccPic ? $picDoc->ccPic->name : '-' }}</td>
                                                        <td>
                                                            <form action="{{ route('pic.documents.destroy', [$pic->id, $picDoc->id]) }}" method="POST" style="display:inline;">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center text-muted">Belum ada dokumen yang ditugaskan ke PIC ini.</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
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
                                <input type="text" class="form-control" id="pic_department" name="department" placeholder="Masukkan Departemen" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pic_section" class="form-label">Section (optional)</label>
                                <input type="text" class="form-control" id="pic_section" name="section" placeholder="Masukkan Section">
                            </div>
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


