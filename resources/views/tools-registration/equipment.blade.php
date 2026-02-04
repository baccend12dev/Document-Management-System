@extends('layouts.layout')

@section('title', 'Equipment Qualification')

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

            <!-- Header -->
            <div class="card shadow-lg" style="border-radius: 0.5rem; border-left: 4px solid #4f46e5;">
                <div class="card-body p-4">
                    <h5 class="mb-3 font-weight-bold">
                        <i class="fas fa-filter mr-2"></i>Filter & Search Equipment
                    </h5>
                    <form method="GET" action="{{ route('tools.show', 'equipment') }}">
                        <div class="row">
                            <!-- Search -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-semibold">Search</label>
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Search by ID, Name, Model, Serial..." 
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            
                            <!-- Filter by Building -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-semibold">Building</label>
                                    <select class="form-control" name="building">
                                        <option value="">All Buildings</option>
                                        <option value="NBL" {{ request('building') == 'NBL' ? 'selected' : '' }}>NBL</option>
                                        <option value="CPL" {{ request('building') == 'CPL' ? 'selected' : '' }}>CPL</option>
                                        <option value="QC" {{ request('building') == 'QC' ? 'selected' : '' }}>QC</option>
                                        <option value="RD" {{ request('building') == 'RD' ? 'selected' : '' }}>RD</option>
                                        <option value="LG" {{ request('building') == 'LG' ? 'selected' : '' }}>LG</option>
                                        <option value="QCR" {{ request('building') == 'QCR' ? 'selected' : '' }}>QCR</option>
                                        <option value="NCL" {{ request('building') == 'NCL' ? 'selected' : '' }}>NCL</option>
                                        <option value="NBQ" {{ request('building') == 'NBQ' ? 'selected' : '' }}>NBQ</option>
                                        <option value="CRD" {{ request('building') == 'CRD' ? 'selected' : '' }}>CRD</option>
                                        <option value="NCQ" {{ request('building') == 'NCQ' ? 'selected' : '' }}>NCQ</option>
                                        <option value="NQL" {{ request('building') == 'NQL' ? 'selected' : '' }}>NQL</option>
                                        <option value="NCG" {{ request('building') == 'NCG' ? 'selected' : '' }}>NCG</option>
                                        <option value="NCR" {{ request('building') == 'NCR' ? 'selected' : '' }}>NCR</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Filter by Department -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-semibold">Department</label>
                                    <select class="form-control" name="department">
                                        <option value="">All Departments</option>
                                        <option value="TM" {{ request('department') == 'TM' ? 'selected' : '' }}>TM</option>
                                        <option value="PR" {{ request('department') == 'PR' ? 'selected' : '' }}>PR</option>
                                        <option value="LG" {{ request('department') == 'LG' ? 'selected' : '' }}>LG</option>
                                        <option value="RD" {{ request('department') == 'RD' ? 'selected' : '' }}>RD</option>
                                        <option value="QA" {{ request('department') == 'QA' ? 'selected' : '' }}>QA</option>
                                        <option value="QC" {{ request('department') == 'QC' ? 'selected' : '' }}>QC</option>
                                        <option value="IT" {{ request('department') == 'IT' ? 'selected' : '' }}>IT</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="col-md-2">
                                <label class="font-weight-semibold d-block">&nbsp;</label>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary btn-sm mr-1">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    <a href="{{ route('tools.show', 'equipment') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-redo"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

 <!-- Data Table -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">Equipment List</h5>
                    <button type="button" class="btn btn-light btn-sm font-weight-bold" onclick="document.getElementById('addEquipmentForm').scrollIntoView({ behavior: 'smooth' });">
                        <i class="fas fa-plus mr-1"></i> Add New
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Equipment ID</th>
                                <th>Equipment Name</th>
                                <th>Building</th>
                                <th>Department</th>
                                <th>Model</th>
                                <th>Serial Number</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $item->equipment_id }}</td>
                                <td>{{ $item->equipment_name }}</td>
                                <td>{{ $item->building }}</td>
                                <td>{{ $item->department }}</td>
                                <td>{{ $item->model }}</td>
                                <td>{{ $item->serial_number  }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tools.destroy', [$item->id]) }}" method="POST"
                                        style="display:inline;">
                                      {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No equipment data available
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of
                            {{ count($data) }} entries
                        </span>
                        <span class="text-muted">
                            {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </span>
                    </div>
                </div>
                </div>
            </div>

            <!-- Add Form -->
            <div class="form-section" id="addEquipmentForm">
                <h3 class="mb-4 font-weight-bold">Add New Equipment</h3>
                <form action="{{ route('tools.store.equipment') }}" method="POST">
                    {{ csrf_field() }}
                    <!-- hiide input sub menu -->
                    <input type="hidden" name="sub_menu" value="equipment">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Equipment ID <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="equipment_id" id="equipmentId"
                                        placeholder="e.g., QA-D-MC-02" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info" id="checkEquipmentIdBtn">
                                            Check
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Equipment Name <span
                                        class="text-danger"></span></label>
                                <input type="text" class="form-control" name="equipment_name" id="equipmentName"
                                    placeholder="e.g., HVAC System" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Building</label>
                                <select class="form-control" name="building" id="building" required>
                                    <option value="">Select Building</option>
                                    <option value="NBL">NBL</option>
                                    <option value="CPL">CPL</option>
                                    <option value="QC">QC</option>
                                    <option value="RD">RD</option>
                                    <option value="LG">LG</option>
                                    <option value="QCR">QCR</option>
                                    <option value="NCL">NCL</option>
                                    <option value="NBQ">NBQ</option>
                                    <option value="CRD">CRD</option>
                                    <option value="NCQ">NCQ</option>
                                    <option value="NQL">NQL</option>
                                    <option value="NCG">NCG</option>
                                    <option value="NCR">NCR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Department</label>
                                <select class="form-control" name="department" id="department" required>
                                    <option value="">Select Department</option>
                                    <option value="TM">TM (Technical and Maintenance)</option>
                                    <option value="PR">PR (Production)</option>
                                    <option value="LG">LG (Logistic)</option>
                                    <option value="RD">RD (Research and Development)</option>
                                    <option value="QA">QA (Quality Assurance)</option>
                                    <option value="QC">QC (Quality Control)</option>
                                    <option value="IT">IT (Information Technology)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Room Name</label>
                                    <input type="text" class="form-control" name="roomName" id="roomName"
                                        placeholder="e.g., Conference Room, Lab A">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Room Number</label>
                                <input type="text" class="form-control" name="roomNumber" id="roomNumber"
                                    placeholder="e.g., Room 101, 1st Floor">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Model</label>
                                <input type="text" class="form-control" name="model" id="brand" placeholder="e.g., Acme Corp">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Type</label>
                                <input type="text" class="form-control" name="type" id="type" placeholder="e.g., XYZ-1000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Serial Number</label>
                                <input type="text" class="form-control" name="serial_number" id="serialNumber"
                                    placeholder="e.g., SN123456789">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Remark</label>
                                <input type="text" class="form-control" name="remarks" id="remarks"
                                    placeholder="Additional notes or comments">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn-custom btn-primary-custom">
                            <i class="fas fa-save mr-2"></i> Submit
                        </button>
                        <a href="{{ route('tools-registration.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                    </div>
                </form>
            </div>
           

        </div>
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
    $(document).ready(function() {
    $('#checkEquipmentIdBtn').click(function() {
        const equipmentId = $('input[name="equipment_id"]').val().trim();
        if (!equipmentId) return alert('Please enter Equipment ID first.');

        $.get(`/api/equipment/check-id?equipment_id=${equipmentId}`, function(data) {
            if (data.success && data.data) {
                const departmentMapping = {
                    'Technical and Maintenance': 'TM',
                    'Production': 'PR',
                    'Logistic': 'LG',
                    'Research and Development': 'RD',
                    'Quality Assurance': 'QA',
                    'Quality Control': 'QC',
                    'Information Technology': 'IT'
                };
                const departmentValue = departmentMapping[data.data.Departemen] || data.data.Departemen;
                // Isi form
                $('#equipmentName').val(data.data.EquipmentName || '').prop('readonly', true);
                $('select[name="building"]').val(data.data.Building || '').prop('disabled', true);
                 $('select[name="department"]').val(departmentValue).prop('disabled', true);
                $('#roomName').val(data.data.RoomName || '').prop('readonly', true);
                $('#roomNumber').val(data.data.RoomNumber || '').prop('readonly', true);
                $('#brand').val(data.data.Brand || '').prop('readonly', true);
                $('#type').val(data.data.Type || '').prop('readonly', true);
                $('#serialNumber').val(data.data.SerialNumber || '').prop('readonly', true);
                $('#remarks').val(data.data.Remarks || '').prop('readonly', true);
            } else {
                // Reset form
                $('#equipmentName, #brand, #type, #serialNumber, #roomName, #roomNumber').val('').prop('readonly', false);
                $('select[name="building"]').val('').prop('disabled', false);
                $('select[name="department"]').val('').prop('disabled', false);
                alert('Equipment not found.');
            }
        }).fail(function() {
            alert('Error checking equipment ID.');
        });
    });
});
$('form').on('submit', function() {
    $('select[name="building"]').prop('disabled', false);
     $('select[name="department"]').prop('disabled', false);
});
</script>
@endpush