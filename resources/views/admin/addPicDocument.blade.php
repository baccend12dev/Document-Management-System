@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Dokumen untuk PIC: {{ $pic->name }}
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pic.store-document', $pic->id) }}" method="POST">
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <label for="document_id" class="form-label">Pilih Dokumen <span class="text-danger">*</span></label>
                            <select class="form-control" id="document_id" name="document_id" required>
                                <option value="">-- Pilih Dokumen --</option>
                                @foreach($documents as $doc)
                                    <option value="{{ $doc->id }}">
                                        [{{ $doc->sub_menu }}] - {{ $doc->doc_number }} - {{ $doc->document_type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ccpic_id" class="form-label">CC PIC (Opsional)</label>
                            <select class="form-control" id="ccpic_id" name="ccpic_id">
                                <option value="">-- Tidak ada CC --</option>
                                @foreach($ccpics as $cc)
                                    <option value="{{ $cc->id }}">{{ $cc->name }} ({{ $cc->department }} - {{ $cc->section }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.list-pic') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary ml-2">Simpan Dokumen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        border: 1px solid #ced4da;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
        color: #495057;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#document_id').select2({
        placeholder: "Cari nomor atau tipe dokumen...",
        allowClear: true,
        width: '100%'
    });
    
    $('#ccpic_id').select2({
        placeholder: "Cari nama PIC...",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection
