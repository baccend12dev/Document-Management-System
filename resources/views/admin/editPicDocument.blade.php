@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit CC PIC untuk Dokumen
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pic.documents.update', [$pic->id, $picDoc->id]) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">PIC Utama</label>
                            <input type="text" class="form-control" value="{{ $pic->name }}" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Dokumen</label>
                            <input type="text" class="form-control" value="[{{ $document->sub_menu }}] - {{ $document->doc_number }} - {{ $document->document_type }}" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label for="ccpic_id" class="form-label font-weight-bold">CC PIC (Opsional, Bisa pilih lebih dari satu)</label>
                            <select class="form-control" id="ccpic_id" name="ccpic_id[]" multiple="multiple">
                                @foreach($allPics as $otherPic)
                                    <option value="{{ $otherPic->id }}" {{ in_array($otherPic->id, $currentCcIds) ? 'selected' : '' }}>
                                        {{ $otherPic->name }} ({{ $otherPic->department }} - {{ $otherPic->section }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.list-pic') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-warning ml-2">Simpan Perubahan</button>
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
    .select2-container .select2-selection--multiple {
        min-height: 38px !important;
        border: 1px solid #ced4da;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#ccpic_id').select2({
        placeholder: "Cari nama PIC...",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection
