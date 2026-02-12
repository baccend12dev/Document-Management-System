@extends('layouts.layout')

@section('styles')
<style>
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        border-radius: 4px;
        min-height: 38px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #007bff;
        border-color: #006fe6;
        color: #fff;
        padding: 2px 8px;
        border-radius: 3px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
        margin-right: 5px;
    }
    .card-header-custom {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: #fff;
    }
    .table th {
        font-size: 0.85rem;
        white-space: nowrap;
    }
    .table td {
        font-size: 0.83rem;
    }
    .badge-multi {
        display: inline-block;
        margin: 1px 2px;
        padding: 3px 7px;
        font-size: 0.75rem;
        border-radius: 3px;
        background-color: #17a2b8;
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="row mt-3">
    <div class="col-12">
        {{-- ====== FORM ADD DATA ====== --}}
        <div class="card card-outline card-primary">
            <div class="card-header card-header-custom">
                <h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i> Tambah Utility Masterlist</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('utility.masterlist.store') }}" method="POST" id="formUtilityMasterlist">
                    {{csrf_field()}}
                    <div class="row">
                        {{-- Subject --}}
                        <div class="col-md-3 mb-3">
                            <label for="subject">Subject</label>
                            <select name="subject[]" id="subject" class="form-control select2" multiple="multiple" data-placeholder="Pilih Subject">
                                @foreach($subjects as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- System --}}
                        <div class="col-md-3 mb-3">
                            <label for="system">System</label>
                            <select name="system[]" id="system" class="form-control select2" multiple="multiple" data-placeholder="Pilih System">
                                @foreach($systems as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Model --}}
                        <div class="col-md-3 mb-3">
                            <label for="model">Model</label>
                            <select name="model[]" id="model" class="form-control select2" multiple="multiple" data-placeholder="Pilih Model">
                                @foreach($models as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Building --}}
                        <div class="col-md-3 mb-3">
                            <label for="building">Building</label>
                            <select name="building[]" id="building" class="form-control select2" multiple="multiple" data-placeholder="Pilih Building">
                                @foreach($buildings as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Location --}}
                        <div class="col-md-3 mb-3">
                            <label for="location">Location</label>
                            <select name="location[]" id="location" class="form-control select2" multiple="multiple" data-placeholder="Pilih Location">
                                @foreach($locations as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Service Area --}}
                        <div class="col-md-3 mb-3">
                            <label for="servicearea">Service Area</label>
                            <select name="servicearea[]" id="servicearea" class="form-control select2" multiple="multiple" data-placeholder="Pilih Service Area">
                                @foreach($serviceareas as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Room Number --}}
                        <div class="col-md-3 mb-3">
                            <label for="roomNumber">Room Number</label>
                            <select name="roomNumber[]" id="roomNumber" class="form-control select2" multiple="multiple" data-placeholder="Pilih Room Number">
                                @foreach($roomNumbers as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Room Name --}}
                        <div class="col-md-3 mb-3">
                            <label for="roomName">Room Name</label>
                            <select name="roomName[]" id="roomName" class="form-control select2" multiple="multiple" data-placeholder="Pilih Room Name">
                                @foreach($roomNames as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary" id="btnSave">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-secondary ml-2" onclick="$('.select2').val(null).trigger('change');">
                                <i class="fas fa-undo mr-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ====== TABLE DATA ====== --}}
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list mr-1"></i> Data Utility Masterlist</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 10px"></th>
                            <th style="width: 40px">#</th>
                            <th>Subject</th>
                            <th>System</th>
                            <th>Model</th>
                            <th>Building</th>
                            <th>Location</th>
                            <th>Service Area</th>
                            <th style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $row)
                        <tr>
                            <td>
                                <button type="button" class="btn btn-xs btn-success btn-expand" title="Lihat Detail Room">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                            <td>{{ $data->firstItem() + $index }}</td>
                            <td>
                                @foreach(explode(',', $row->subject ? $row->subject : '') as $val)
                                    @if($val)<span class="badge-multi">{{ $val }}</span>@endif
                                @endforeach
                            </td>
                            <td>
                                @foreach(explode(',', $row->system ? $row->system : '') as $val)
                                    @if($val)<span class="badge-multi">{{ $val }}</span>@endif
                                @endforeach
                            </td>
                            <td>
                                @foreach(explode(',', $row->model ? $row->model : '') as $val)
                                    @if($val)<span class="badge-multi">{{ $val }}</span>@endif
                                @endforeach
                            </td>
                            <td>
                                @foreach(explode(',', $row->building ? $row->building : '') as $val)
                                    @if($val)<span class="badge-multi">{{ $val }}</span>@endif
                                @endforeach
                            </td>
                            <td>
                                @foreach(explode(',', $row->location ? $row->location : '') as $val)
                                    @if($val)<span class="badge-multi">{{ $val }}</span>@endif
                                @endforeach
                            </td>
                            <td>
                                @foreach(explode(',', $row->servicearea ? $row->servicearea : '') as $val)
                                    @if($val)<span class="badge-multi">{{ $val }}</span>@endif
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('utility.document', $row->id) }}" class="btn btn-sm btn-info" title="Lihat Dokumen">
                                    <i class="fas fa-file-alt"></i>
                                </a>
                                <button class="btn btn-sm btn-warning btn-edit"
                                    data-id="{{ $row->id }}"
                                    data-subject="{{ $row->subject }}"
                                    data-system="{{ $row->system }}"
                                    data-model="{{ $row->model }}"
                                    data-building="{{ $row->building }}"
                                    data-location="{{ $row->location }}"
                                    data-servicearea="{{ $row->servicearea }}"
                                    data-roomnumber="{{ $row->roomNumber }}"
                                    data-roomname="{{ $row->roomName }}"
                                    data-toggle="modal" data-target="#editModal" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('utility.masterlist.destroy', $row->id) }}" method="POST" style="display:inline;" class="form-delete">
                                    {{csrf_field()}}
                                    {{method_field('DELETE')}}
                                    <button type="submit" class="btn btn-sm btn-danger btn-delete" title="Hapus Data">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr class="expand-row d-none bg-light">
                            <td colspan="9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong class="d-block mb-1 text-info"><i class="fas fa-door-open mr-1"></i> Room Number:</strong>
                                        <div style="max-height: 150px; overflow-y: auto;">
                                            @forelse(explode(',', $row->roomNumber ? $row->roomNumber : '') as $val)
                                                @if($val)<span class="badge badge-info mr-1 mb-1" style="font-size: 90%;">{{ $val }}</span>@endif
                                            @empty
                                                <span class="text-muted">-</span>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <strong class="d-block mb-1 text-secondary"><i class="fas fa-tag mr-1"></i> Room Name:</strong>
                                        <div style="max-height: 150px; overflow-y: auto;">
                                            @forelse(explode(',', $row->roomName ? $row->roomName : '') as $val)
                                                @if($val)<span class="badge badge-secondary mr-1 mb-1" style="font-size: 90%;">{{ $val }}</span>@endif
                                            @empty
                                                <span class="text-muted">-</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i> Belum ada data.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>

{{-- ====== EDIT MODAL ====== --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="editForm" method="POST">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <div class="modal-header bg-warning">
                    <h5 class="modal-title"><i class="fas fa-edit mr-1"></i> Edit Utility Masterlist</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Subject</label>
                            <select name="subject[]" id="editSubject" class="form-control select2-edit" multiple="multiple" data-placeholder="Pilih Subject">
                                @foreach($subjects as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>System</label>
                            <select name="system[]" id="editSystem" class="form-control select2-edit" multiple="multiple" data-placeholder="Pilih System">
                                @foreach($systems as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Model</label>
                            <select name="model[]" id="editModel" class="form-control select2-edit" multiple="multiple" data-placeholder="Pilih Model">
                                @foreach($models as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Building</label>
                            <select name="building[]" id="editBuilding" class="form-control select2-edit" multiple="multiple" data-placeholder="Pilih Building">
                                @foreach($buildings as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Location</label>
                            <select name="location[]" id="editLocation" class="form-control select2-edit" multiple="multiple" data-placeholder="Pilih Location">
                                @foreach($locations as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Service Area</label>
                            <select name="servicearea[]" id="editServicearea" class="form-control select2-edit" multiple="multiple" data-placeholder="Pilih Service Area">
                                @foreach($serviceareas as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Room Number</label>
                            <select name="roomNumber[]" id="editRoomNumber" class="form-control select2-edit" multiple="multiple" data-placeholder="Pilih Room Number">
                                @foreach($roomNumbers as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Room Name</label>
                            <select name="roomName[]" id="editRoomName" class="form-control select2-edit" multiple="multiple" data-placeholder="Pilih Room Name">
                                @foreach($roomNames as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Init Select2 for main form with tags enabled (allow custom input)
    $('.select2').select2({
        tags: true,
        width: '100%',
        placeholder: function() {
            return $(this).data('placeholder');
        }
    });

    // Init Select2 for edit modal (need to re-init after modal shown)
    $('#editModal').on('shown.bs.modal', function () {
        $('.select2-edit').select2({
            tags: true,
            dropdownParent: $('#editModal'),
            width: '100%'
        });
    });

    // Edit button click – populate modal fields
    $('.btn-edit').on('click', function() {
        var id          = $(this).data('id');
        var subject     = $(this).data('subject') ? $(this).data('subject').toString().split(',') : [];
        var system      = $(this).data('system') ? $(this).data('system').toString().split(',') : [];
        var model       = $(this).data('model') ? $(this).data('model').toString().split(',') : [];
        var building    = $(this).data('building') ? $(this).data('building').toString().split(',') : [];
        var location    = $(this).data('location') ? $(this).data('location').toString().split(',') : [];
        var servicearea = $(this).data('servicearea') ? $(this).data('servicearea').toString().split(',') : [];
        var roomnumber  = $(this).data('roomnumber') ? $(this).data('roomnumber').toString().split(',') : [];
        var roomname    = $(this).data('roomname') ? $(this).data('roomname').toString().split(',') : [];

        // Set form action
        $('#editForm').attr('action', '/utility-masterlist/' + id);

        // Set values after a small delay to let Select2 init
        setTimeout(function() {
            $('#editSubject').val(subject).trigger('change');
            $('#editSystem').val(system).trigger('change');
            $('#editModel').val(model).trigger('change');
            $('#editBuilding').val(building).trigger('change');
            $('#editLocation').val(location).trigger('change');
            $('#editServicearea').val(servicearea).trigger('change');
            $('#editRoomNumber').val(roomnumber).trigger('change');
            $('#editRoomName').val(roomname).trigger('change');
        }, 300);
    });

    // Delete confirmation with SweetAlert2
    $('.form-delete').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: 'Data yang dihapus tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Spinner on submit
    $('#formUtilityMasterlist').on('submit', function() {
        $('#btnSave').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');
    });

    // Expand Row Logic
    $('.btn-expand').on('click', function() {
        var tr = $(this).closest('tr');
        var nextTr = tr.next('.expand-row');
        var icon = $(this).find('i');

        if(nextTr.hasClass('d-none')) {
            nextTr.removeClass('d-none');
            $(this).removeClass('btn-success').addClass('btn-danger');
            icon.removeClass('fa-plus').addClass('fa-minus');
        } else {
            nextTr.addClass('d-none');
            $(this).removeClass('btn-danger').addClass('btn-success');
            icon.removeClass('fa-minus').addClass('fa-plus');
        }
    });
});
</script>
@endsection
