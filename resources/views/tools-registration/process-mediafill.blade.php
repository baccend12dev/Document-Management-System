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
                    <!-- fillter and search product -->
            <div class="h5">Filter & Search Product</div>
            <form method="GET" action="{{ route('tools.show', 'process-mediafill') }}" class="mt-3">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search product name or code..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary-custom">Search</button>
                        <a href="{{ route('tools.show', 'process-mediafill') }}" class="btn btn-light border">Reset</a>
                    </div>
                </div>
            </form>

            </div>
            </div>
            <!-- Data Table -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">Process & Mediafill List</h5>
                    <button type="button" class="btn btn-light btn-sm font-weight-bold" onclick="document.getElementById('addProcessMediafillForm').scrollIntoView({ behavior: 'smooth' });">
                        <i class="fas fa-plus"></i> Add New
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Active Substance</th>
                                <th>Building</th>
                                <th>Dosage Code</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $item->product_code }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->active_subtance }}</td>
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
            <div class="form-section" id="addProcessMediafillForm">
                <h3 class="mb-4 font-weight-bold">Add New Products</h3>

                <form action="{{ route('tools.store.mediafill') }}" method="POST" id="multiProductForm">
                    {{ csrf_field() }}
                    <!-- hidden input sub menu -->
                    <input type="hidden" name="sub_menu" value="process-mediafill">
                    
                    <!-- Master Fields Section -->
                    <div class="card mb-2" style="border-left: 4px solid #10b981;">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0 font-weight-semibold">
                                <i class="fas fa-info-circle mr-2"></i>Master Information (Applies to All Products)
                            
                            </h6>
                        </div>
                        <div class="card-body py-2 px-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="font-weight-semibold mb-1">Active Substance <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="masterActiveSubstance" placeholder="Enter Active Substance" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="font-weight-semibold mb-1">Building <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm" id="masterBuilding" required>
                                            <option value="">Select Building</option>
                                            <option value="NBL">NBL</option>
                                            <option value="CPL">CPL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Entry Section -->
                    <div class="card mb-3" style="border-left: 4px solid #4f46e5;">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0 font-weight-semibold"><i class="fas fa-box mr-2"></i>Product Details <span id="masterSummary" class="ml-3 text-muted small"></span></h6>
                            
                        </div>
                        <div class="card-body py-3 px-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="font-weight-semibold mb-1">Dosage Code <span class="text-danger">*</span></label>
                                        <div class="d-flex">
                                            <select class="form-control form-control-sm mr-2" id="dosageCode">
                                                <option value="">Select Dosage</option>
                                                <option value="INA">INA (Ampule Injection)</option>
                                                <option value="INF">INF (Infus)</option>
                                                <option value="INV">INV (Vial Injection)</option>
                                                <option value="KPS">KPS (Capsule)</option>
                                                <option value="KPT">KPT (Caplet)</option>
                                                <option value="SYK">SYK (Dry Syrup)</option>
                                                <option value="SYR">SYR (Syrup)</option>
                                                <option value="TAB">TAB (Tablet)</option>
                                                <option value="XXX">XXX (Water For Injection)</option>
                                            </select>
                                            <input type="number" class="form-control form-control-sm" id="dosageNumber" placeholder="Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="font-weight-semibold mb-1">Product Code <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" id="productCode" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="font-weight-semibold mb-1">Product Type <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm" id="productType">
                                            <option value="">Select Product Type</option>
                                            <option value="FGL">FGL (Finished Goods Local)</option>
                                            <option value="FGX">FGX (Finished Goods Export)</option>
                                            <option value="TIN">TIN (Toll IN Product)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="font-weight-semibold mb-1">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="productName" placeholder="Enter Product Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="font-weight-semibold mb-1">No Batch</label>
                                        <input type="text" class="form-control form-control-sm" id="noBatch" placeholder="Enter Batch Number">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="button" class="btn-custom btn-primary-custom btn-sm" id="addProductBtn">
                                    <i class="fas fa-plus mr-2"></i> Add to List
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Products List Table -->
                    <div class="card mb-4" style="border-left: 4px solid #f59e0b;">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 font-weight-semibold">Products to be Saved (<span id="productCount">0</span>)</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="productsTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="15%">Product Code</th>
                                            <th width="20%">Product Name</th>
                                            <th width="15%">Product Type</th>
                                            <th width="15%">Dosage Code</th>
                                            <th width="15%">No Batch</th>
                                            <th width="10%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productsTableBody">
                                        <tr id="emptyRow">
                                            <td colspan="7" class="text-center text-muted py-4">
                                                No products added yet. Please add products using the form above.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden inputs for products data -->
                    <div id="hiddenInputsContainer"></div>

                    <!-- Action Buttons -->
                    <div class="mt-4">
                        <button type="submit" class="btn-custom btn-primary-custom" id="saveAllBtn" disabled>
                            <i class="fas fa-save mr-2"></i> Save All Products
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Array to store products
    let products = [];

    // Auto-generate product code
    $('#dosageCode, #dosageNumber, #productType').on('change input', function() {
        var dosageCode   = $('#dosageCode').val() || '';
        var dosageNumber = $('#dosageNumber').val() || '';
        var productType  = $('#productType').val() || '';

        // Build code even if some fields are empty
        var productCode = dosageCode + dosageNumber;

        // Add dash only if productType exists
        if (productType !== '') {
            productCode += '-' + productType;
        }

        // Set result to input
        $('#productCode').val(productCode.toUpperCase());
    });

    // Update master summary display
    function updateMasterSummary() {
        var activeSubstance = $('#masterActiveSubstance').val().trim();
        var building = $('#masterBuilding').val();
        
        if (activeSubstance || building) {
            var summary = '';
            if (activeSubstance) {
                summary += '📋 ' + activeSubstance;
            }
            if (building) {
                summary += (activeSubstance ? ' | ' : '') + '🏢 ' + building;
            }
            $('#masterSummary').html(summary).removeClass('text-muted').addClass('text-success font-weight-bold');
        } else {
            $('#masterSummary').html('').removeClass('text-success font-weight-bold').addClass('text-muted');
        }
    }

    // Listen to master fields changes
    $('#masterActiveSubstance, #masterBuilding').on('change input', function() {
        updateMasterSummary();
    });

    // Add product to list
    $('#addProductBtn').on('click', function() {
        // Get master fields
        var activeSubstance = $('#masterActiveSubstance').val().trim();
        var building = $('#masterBuilding').val();

        // Get product fields
        var dosageCode = $('#dosageCode').val();
        var dosageNumber = $('#dosageNumber').val();
        var productCode = $('#productCode').val();
        var productType = $('#productType').val();
        var productName = $('#productName').val().trim();
        var noBatch = $('#noBatch').val().trim();

        // Validation
        if (!activeSubstance) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please enter Active Substance in Master Information',
                confirmButtonColor: '#4f46e5'
            });
            return;
        }

        if (!building) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please select Building in Master Information',
                confirmButtonColor: '#4f46e5'
            });
            return;
        }

        if (!dosageCode || !dosageNumber || !productType || !productName) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill all required product fields (Dosage Code, Number, Product Type, and Product Name)',
                confirmButtonColor: '#4f46e5'
            });
            return;
        }

        // Check for duplicate product code
        var isDuplicate = products.some(function(product) {
            return product.productCode === productCode;
        });

        if (isDuplicate) {
            Swal.fire({
                icon: 'error',
                title: 'Duplicate Product',
                text: 'Product with code ' + productCode + ' already exists in the list',
                confirmButtonColor: '#4f46e5'
            });
            return;
        }

        // Add product to array
        var product = {
            dosageCode: dosageCode,
            dosageNumber: dosageNumber,
            productCode: productCode,
            productType: productType,
            productName: productName,
            noBatch: noBatch,
            activeSubstance: activeSubstance,
            building: building
        };

        products.push(product);

        // Update table
        updateProductsTable();

        // Clear product form fields (keep master fields)
        $('#dosageCode').val('');
        $('#dosageNumber').val('');
        $('#productCode').val('');
        $('#productType').val('');
        $('#productName').val('');
        $('#noBatch').val('');

        // Show success message
        Swal.fire({
            icon: 'success',
            title: 'Product Added',
            text: 'Product ' + productCode + ' has been added to the list',
            timer: 1500,
            showConfirmButton: false
        });
    });

    // Update products table
    function updateProductsTable() {
        var tbody = $('#productsTableBody');
        tbody.empty();

        if (products.length === 0) {
            tbody.append(`
                <tr id="emptyRow">
                    <td colspan="7" class="text-center text-muted py-4">
                        No products added yet. Please add products using the form above.
                    </td>
                </tr>
            `);
            $('#saveAllBtn').prop('disabled', true);
        } else {
            products.forEach(function(product, index) {
                tbody.append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td><strong>${product.productCode}</strong></td>
                        <td>${product.productName}</td>
                        <td>${product.productType}</td>
                        <td><span class="badge badge-info">${product.dosageCode}${product.dosageNumber}</span></td>
                        <td>${product.noBatch || '-'}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeProduct(${index})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
            $('#saveAllBtn').prop('disabled', false);
        }

        // Update product count
        $('#productCount').text(products.length);

        // Update hidden inputs
        updateHiddenInputs();
    }

    // Update hidden inputs for form submission
    function updateHiddenInputs() {
        var container = $('#hiddenInputsContainer');
        container.empty();

        products.forEach(function(product, index) {
            container.append(`
                <input type="hidden" name="products[${index}][dosageCode]" value="${product.dosageCode}">
                <input type="hidden" name="products[${index}][dosageNumber]" value="${product.dosageNumber}">
                <input type="hidden" name="products[${index}][product_code]" value="${product.productCode}">
                <input type="hidden" name="products[${index}][type]" value="${product.productType}">
                <input type="hidden" name="products[${index}][product_name]" value="${product.productName}">
                <input type="hidden" name="products[${index}][no_batch]" value="${product.noBatch}">
                <input type="hidden" name="products[${index}][active_subtance]" value="${product.activeSubstance}">
                <input type="hidden" name="products[${index}][building]" value="${product.building}">
            `);
        });
    }

    // Remove product from list (global function)
    window.removeProduct = function(index) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Remove product " + products[index].productCode + " from the list?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                products.splice(index, 1);
                updateProductsTable();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Removed!',
                    text: 'Product has been removed from the list.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    };

    // Form submission validation
    $('#multiProductForm').on('submit', function(e) {
        if (products.length === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'No Products',
                text: 'Please add at least one product before saving',
                confirmButtonColor: '#4f46e5'
            });
            return false;
        }
    });
});
</script>
@endsection