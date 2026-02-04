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
            <!-- Header -->
            <div class="card shadow-lg" style="border-radius: 0.5rem; border-left: 4px solid #4f46e5;">
                <div class="card-body p-4">
                    <div class="h5">Filter & Search Product</div>
            <form method="GET" action="{{ route('tools.show', 'cleaning') }}" class="mt-3">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search product name or code..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary-custom">Search</button>
                        <a href="{{ route('tools.show', 'cleaning') }}" class="btn btn-light border">Reset</a>
                    </div>
                </div>
            </form>
                </div>
            </div>
<!-- Data Table -->
            <div class="card shadow-lg">
                     <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">Cleaning Validation List</h5>
                    <button type="button" class="btn btn-light btn-sm font-weight-bold" onclick="document.getElementById('addEquipmentForm').scrollIntoView({ behavior: 'smooth' });">
                        <i class="fas fa-plus mr-1"></i> Add New
                    </button>
                </div>
                 
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Active Subtance</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Equipment ID</th>
                                <th>Building</th>
                                <th>Dosage Code</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $item->active_subtance }}</td>
                                <td>{{ $item->product_code }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->equipment_id }}</td>
                                <td>{{ $item->building}}</td>
                                <td>
                                    <span class="badge badge-info">{{ $item->dosageCode }}</span>
                                </td>
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
                <h3 class="mb-4 font-weight-bold">Add New Product</h3>

                <form action="{{ route('tools.store.equipment') }}" method="POST" id="cleaningForm">
                    {{ csrf_field() }}
                    <!-- hiide input sub menu -->
                    <input type="hidden" name="sub_menu" value="cleaning">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Active Subtance</label>
                                <select class="form-control" name="active_subtance" id="activeSubtance">
                                    <option value="">Select Active Subtance</option>
                                    @foreach ($zatSubstans as $zatSubstan)
                                        <option value="{{ $zatSubstan }}">{{ $zatSubstan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                        <!--ADD BUILDING-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Building</label>
                                <select class="form-control" name="building" id="building">
                                    <option value="">Select Building</option>
                                    <option value="NBL">NBL</option>
                                    <option value="CPL">CPL</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-semibold">Equipment Name <span
                                        class="text-danger"></span></label>
                                <input type="text" class="form-control" name="equipment_name" id="equipmentName">
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
                    </div>
                    <!-- tabel for list prodcut use zat active, use checkbox -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">List Product Use Zat Active</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="productTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Product Code</th>
                                            <th>Product Name</th>
                                            <th>
                                                <input type="checkbox" id="selectAll"> Select All
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="productListTable">
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                Please select an Active Substance to view products
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Hidden input to store selected product codes as comma-separated string -->
                     <input type="hidden" name="product_name" id="productNameInput" value="">
                    <input type="hidden" name="product_code" id="productCodeInput" value="">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#activeSubtance').select2();

        // AJAX: Load products when active substance is selected
        $('#activeSubtance').on('change', function() {
            const activeSubstance = $(this).val();
            const tableBody = $('#productListTable');

            if (!activeSubstance) {
                tableBody.html(`
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Please select an Active Substance to view products
                        </td>
                    </tr>
                `);
                return;
            }

            // Show loading state
            tableBody.html(`
                <tr>
                    <td colspan="4" class="text-center">
                        <i class="fas fa-spinner fa-spin"></i> Loading products...
                    </td>
                </tr>
            `);

            // AJAX request to get products
            $.ajax({
                url: '/api/products-by-active-substance',
                method: 'GET',
                data: { active_substance: activeSubstance },
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        let rows = '';
                        response.data.forEach(function(product, index) {
                            rows += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${product.product_code || '-'}</td>
                                    <td>${product.product_name || '-'}</td>
                                    <td class="text-center">
                                        <input type="checkbox" name="selected_products[]" 
                                               value="${product.product_code}" 
                                               data-product-code="${product.product_code}"
                                               data-product-name="${product.product_name}"
                                               class="product-checkbox">
                                    </td>
                                </tr>
                            `;
                        });
                        tableBody.html(rows);
                    } else {
                        tableBody.html(`
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    No products found for this active substance
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading products:', error);
                    tableBody.html(`
                        <tr>
                            <td colspan="4" class="text-center text-danger">
                                <i class="fas fa-exclamation-triangle"></i> Error loading products. Please try again.
                            </td>
                        </tr>
                    `);
                }
            });
        });

        // Select All functionality
        $('#selectAll').on('change', function() {
            $('.product-checkbox').prop('checked', $(this).prop('checked'));
        });

        // Update Select All checkbox when individual checkboxes change
        $(document).on('change', '.product-checkbox', function() {
            const totalCheckboxes = $('.product-checkbox').length;
            const checkedCheckboxes = $('.product-checkbox:checked').length;
            $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
        });

        // Before form submit, collect all selected product codes and product names
        $('#cleaningForm').on('submit', function(e) {
            const selectedProductCodes = [];
            const selectedProductNames = [];
            $('.product-checkbox:checked').each(function() {
                const productCode = $(this).val();
                const productName = $(this).data('product-name');
                if (productCode) {
                    selectedProductCodes.push(productCode);
                }
                if (productName) {
                    selectedProductNames.push(productName);
                }
            });

            if (selectedProductCodes.length === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'No Products Selected',
                    text: 'Please select at least one product from the list.',
                    confirmButtonColor: '#4f46e5'
                });
                return;
            }
            
            $('#productCodeInput').val(selectedProductCodes.join(', '));
            $('#productNameInput').val(selectedProductNames.join(', '));
        });
    });
</script>
<script>
$(document).ready(function() {
    // Trigger on change of any dropdown/input
    $('#dosageCode, #dosageNumber, #productType').on('change input', function() {
        // Get selected values
        var dosageCode = $('#dosageCode').val();
        var dosageNumber = $('#dosageNumber').val();
        var productType = $('#productType').val();

        // Generate product code
        if (dosageCode && dosageNumber && productType) {
            var productCode = dosageCode + dosageNumber + '-' + productType;
            $('#productCode').val(productCode.toUpperCase());
        } else {
            $('#productCode').val('');
        }
    });
});
</script>
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
$('#cleaningForm').on('submit', function() {
    $('select[name="building"]').prop('disabled', false);
     $('select[name="department"]').prop('disabled', false);
});
</script>
@endpush