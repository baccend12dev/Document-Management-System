@extends('layouts.layout')

@section('title', 'Room Master')

@push('styles')
<style>
    .table-responsive {
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .form-section {
        background: white;
        border-radius: 0.5rem;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .btn-custom {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.25rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-primary-custom {
        background-color: #4f46e5;
        color: white;
    }

    .btn-primary-custom:hover {
        background-color: #4338ca;
    }

    .btn-danger-custom {
        background-color: #ef4444;
        color: white;
    }

    .btn-danger-custom:hover {
        background-color: #dc2626;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <!-- Filter Section -->
            <div class="card shadow-lg mb-4" style="border-radius: 0.5rem; border-left: 4px solid #4f46e5;">
                <div class="card-body p-4">
                    <form action="{{ route('room.master.index') }}" method="GET" id="filterForm">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="font-weight-bold d-block mb-2">Search Room:</label>
                                <input type="text" name="search" class="form-control" placeholder="Search by name or code..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="font-weight-bold d-block mb-2">Filter by Service Area:</label>
                                <select name="service_area" id="service_area_filter" class="form-control" onchange="document.getElementById('filterForm').submit();">
                                    <option value="">-- All Service Areas --</option>
                                    @foreach($serviceAreas as $area)
                                        <option value="{{ $area }}" {{ request('service_area') == $area ? 'selected' : '' }}>{{ $area }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Search</button>
                                @if(request()->has('service_area') && request('service_area') != '' || request()->has('search') && request('search') != '')
                                    <a href="{{ route('room.master.index') }}" class="btn btn-secondary">Clear Filter</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Data Table -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">Room List</h5>
                    <button type="button" class="btn btn-light btn-sm font-weight-bold" data-toggle="modal" data-target="#addModal">
                        <i class="fas fa-plus"></i> Add New
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Room Name</th>
                                <th>Room Code</th>
                                <th>AHU Code</th>
                                <th>Service Area</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($room as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->room_name }}</td>
                                <td>{{ $item->room_code }}</td>
                                <td>{{ $item->ahu_code }}</td>
                                <td>{{ $item->service_area }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-info" title="Edit" 
                                        data-toggle="modal" data-target="#editModal"
                                        data-id="{{ $item->id }}"
                                        data-room_name="{{ $item->room_name }}"
                                        data-room_code="{{ $item->room_code }}"
                                        data-ahu_code="{{ $item->ahu_code }}"
                                        data-service_area="{{ $item->service_area }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('room.master.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this room?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No room data available
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            Showing {{ $room->firstItem() }} to {{ $room->lastItem()}} of {{ $room->total() }} entries
                        </span>
                        <span class="text-muted">
                            {{ $room->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('room.master.store') }}" method="POST">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addModalLabel">Add New Room</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Room Name</label>
                        <input type="text" class="form-control" name="room_name" required>
                    </div>
                    <div class="form-group">
                        <label>Room Code</label>
                        <input type="text" class="form-control" name="room_code" required>
                    </div>
                    <div class="form-group">
                        <label>AHU Code</label>
                        <input type="text" class="form-control" name="ahu_code" required>
                    </div>
                    <div class="form-group">
                        <label>Service Area</label>
                        <select name="service_area" id="service_area" class="form-control" required>
                            <option value="">Select Service Area</option>
                            @foreach ($serviceAreas as $serviceArea)
                                <option value="{{ $serviceArea }}">{{ $serviceArea }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Room</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" id="editForm">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="editModalLabel">Edit Room</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Room Name</label>
                        <input type="text" class="form-control" name="room_name" id="edit_room_name" required>
                    </div>
                    <div class="form-group">
                        <label>Room Code</label>
                        <input type="text" class="form-control" name="room_code" id="edit_room_code" required>
                    </div>
                    <div class="form-group">
                        <label>AHU Code</label>
                        <input type="text" class="form-control" name="ahu_code" id="edit_ahu_code" required>
                    </div>
                    <div class="form-group">
                        <label>Service Area</label>
                        <input type="text" class="form-control" name="service_area" id="edit_service_area" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Update Room</button>
                </div>
            </div>
        </form>
    </div>
</div>

@if ($message = Session::get('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ $message }}',
        confirmButtonColor: '#4f46e5'
    });
});
</script>
@endif

@endsection

@push('scripts')
<script>
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var room_name = button.data('room_name');
        var room_code = button.data('room_code');
        var ahu_code = button.data('ahu_code');
        var service_area = button.data('service_area');
        
        var modal = $(this);
        modal.find('#edit_room_name').val(room_name);
        modal.find('#edit_room_code').val(room_code);
        modal.find('#edit_ahu_code').val(ahu_code);
        modal.find('#edit_service_area').val(service_area);
        
        // Update the form action
        var formAction = "{{ url('/room-master') }}/" + id;
        modal.find('#editForm').attr('action', formAction);
    });

    $(document).ready(function() {
        if ($('#service_area_filter').length) {
            $('#service_area_filter').select2({
                placeholder: "-- All Service Areas --",
                allowClear: true,
                width: '100%'
            });
        }
    });
</script>
@endpush
