@extends('layouts.layout')

@section('title', 'Utility Qualification')

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
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-8">
                            <label class="font-weight-bold d-block mb-2">Quick Navigation - Select Sub-Menu:</label>
                            <select class="form-control submenu-selector form-control-lg" onchange="navigateToSubMenu(this.value)">
                                <option value="">-- Select a Sub-Menu --</option>
                                <optgroup label="Qualification">
                                    <option value="equipment">⚙️ Equipment Qualification</option>
                                    <option value="utility" selected>⚡ Utility Qualification</option>
                                    <option value="room">🏢 Room Qualification</option>
                                </optgroup>
                                <optgroup label="Validation">
                                    <option value="computer">💻 Computerize System Validation</option>
                                    <option value="process-mediafill">🧪 Process & Mediafill Validation</option>
                                    <option value="cleaning">🧹 Cleaning Validation</option>
                                    <option value="analytical-method">📊 Analytical Method Cleaning Validation</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
 <!-- Data Table -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">Utility List</h5>
                    <button type="button" class="btn btn-light btn-sm font-weight-bold" onclick="document.getElementById('addUtilityForm').scrollIntoView({ behavior: 'smooth' });">
                        <i class="fas fa-plus"></i> Add New
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
            <div class="form-section" id="addUtilityForm">
                <h3 class="mb-4 font-weight-bold">Add New Utility</h3>

                 <form action="{{ route('tools.store.equipment') }}" method="POST">
                    {{ csrf_field() }}
                    <!-- hiide input sub menu -->
                    <input type="hidden" name="sub_menu" value="utility">
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
                                        class="text-danger">*</span></label>
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
                                <label class="font-weight-semibold">Location</label>
                                <select class="form-control" name="location" id="location">
                                    <option value="">Select Location</option>
                                    <option value = "Mezanin NBL 1st Floor +06.00">Mezanin NBL 1st Floor +06.00 </option>
                                    <option value = "Mezanin NBL 1st Floor +06.00">Mezanin NBL 1st Floor +06.00 </option>
                                    <option value = "Water System Room">Water System Room </option>
                                    <option value = "Compressor Room">Compressor Room </option>
                                    <option value = "Mezanin CPL 1st Floor +11.20">Mezanin CPL 1st Floor +11.20 </option>
                                    <option value = "Mezanin CPL 2nd Floor +20.40">Mezanin CPL 2nd Floor +20.40 </option>
                                    <option value = "Technical Area QC">Technical Area QC </option>
                                    <option value = "Technical Area WM 20F01">Technical Area WM 20F01 </option>
                                    <option value = "Mezanin NBL 1st Floor +06.00">Mezanin NBL 1st Floor +06.00 </option>
                                    <option value = "Mezanin NBL 2nd Floor +16.50">Mezanin NBL 2nd Floor +16.50 </option>
                                    <option value = "Mezanin CPL 1st Floor +11.20">Mezanin CPL 1st Floor +11.20 </option>
                                    <option value = "Mezanin CPL 2nd Floor +20.40">Mezanin CPL 2nd Floor +20.40 </option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Serice Area</label>
                                <select class="form-control" name="service_area" id="serviceArea">
                                    <option value="">Select Service Area</option>
                                    <option value="Production Solid Area +0.00">Production Solid Area +0.00</option>
                                    <option value="Production Sterile Area +10.50">Production Sterile Area +10.50</option>
                                    <option value="Production Solid Area +10.50">Production Solid Area +10.50</option>
                                    <option value="Production Liquid Area +10.50">Production Liquid Area +10.50</option>
                                    <option value="Packaging Area +10.50">Packaging Area +10.50</option>
                                    <option value="Production Sterile Area +06.00">Production Sterile Area +06.00</option>
                                    <option value="Packaging Area +06.00">Packaging Area +06.00</option>
                                    <option value="Production Solid Area +15.20">Production Solid Area +15.20</option>
                                    <option value="Packaging Area +15.20">Packaging Area +15.20</option>
                                    <option value="Chemical Laboratory">Chemical Laboratory </option>
                                    <option value="Microbiology Laboratory">Microbiology Laboratory  </option>
                                    <option value="Dispensing Area">Dispensing Area</option>
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
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn-custom btn-primary-custom">
                            <i class="fas fa-save mr-2"></i> Save
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
        $('#serviceArea').select2({
        tags: true,              // memungkinkan input baru
        placeholder: "Select or type Service Area",
        allowClear: true,        // bisa hapus pilihan
        width: '100%'            // biar menyesuaikan form
    });
        $('#location').select2({
        tags: true,              // memungkinkan input baru
        placeholder: "Select or type Service Area",
        allowClear: true,        // bisa hapus pilihan
        width: '100%'            // biar menyesuaikan form
    });


    $('#checkEquipmentIdBtn').click(function() {
        const equipmentId = $('input[name="equipment_id"]').val().trim();
        if (!equipmentId) return alert('Please enter Equipment ID first.');

        $.get(`/api/equipment/check-id?equipment_id=${equipmentId}`, function(data) {
            if (data.success && data.data) {
                console.log(data);
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