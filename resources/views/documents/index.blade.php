@extends('layouts.layout')

@section('title', 'Documents Management')

@push('styles')
<style>
    .modal-custom {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        overflow: auto;
    }

    .modal-custom.show {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-custom-content {
        background-color: #fefefe;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 48rem;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .form-section {
        display: none;
        margin-top: none;
    }

    .form-section.active {
        display: block;
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .tool-radio {
        cursor: pointer;
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }

    .tool-radio:hover {
        background-color: #eef2ff;
        border-color: #818cf8;
    }

    .tool-radio.selected {
        background-color: #eef2ff;
        border-color: #4f46e5;
    }

    .info-box {
        background: linear-gradient(135deg, #f0f4ff 0%, #f3f0ff 100%);
        border: 2px solid #818cf8;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .dropzone {
        border: 2px dashed #818cf8;
        border-radius: 0.5rem;
        padding: 1.5rem;
        text-align: center;
        background-color: #f0f4ff;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dropzone:hover {
        background-color: #e0e7ff;
        border-color: #4f46e5;
    }

    .dropzone.dragover {
        background-color: #dbeafe;
        border-color: #4f46e5;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .status-complete {
        background-color: #dcfce7;
        color: #166534;
    }

    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .table-responsive {
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .table thead th {
        background-color: #4f46e5;
        color: white;
        padding: 0.75rem;
    }

    .table tbody td {
        padding: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .btn-primary-custom {
        background-color: #4f46e5;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary-custom:hover {
        background-color: #4338ca;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        color: white;
    }

    .btn-secondary-custom {
        background-color: #6b7280;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary-custom:hover {
        background-color: #4b5563;
    }

    .btn-success-custom {
        background-color: #10b981;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-success-custom:hover {
        background-color: #059669;
    }

    .custom-small-table {
        font-size: 0.8rem;
        /* Adjust font size */
    }

    .custom-small-table th,
    .custom-small-table td {
        padding: 0.3rem;
        /* Reduce cell padding */
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
                        <div>
                            <h1 class="mb-2 font-weight-bold">
                                <i class="fas fa-file-alt text-primary mr-2"></i>
                                Documents Management
                            </h1>
                            <p class="text-muted mb-0">Manage and upload documents for tools registration</p>
                        </div>
                        <button class="btn btn-primary" onclick="openModal()">
                            <i class="fas fa-plus mr-2"></i>
                            Add New Document
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card shadow" style="border-left: 4px solid #4f46e5;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1 small">Total Documents</p>
                                    <h2 class="mb-0 font-weight-bold" style="color: #4f46e5;">{{ $documents->count() }}
                                    </h2>
                                </div>
                                <i class="fas fa-file-alt fa-2x" style="color: #4f46e5; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow" style="border-left: 4px solid #06b6d4;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1 small">Equipment</p>
                                    <h2 class="mb-0 font-weight-bold" style="color: #06b6d4;">
                                        {{ $documents->where('sub_menu', 'equipment')->count() }}
                                    </h2>
                                </div>
                                <i class="fas fa-wrench fa-2x" style="color: #06b6d4; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow" style="border-left: 4px solid #eab308;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1 small">Utility</p>
                                    <h2 class="mb-0 font-weight-bold" style="color: #eab308;">
                                        {{ $documents->where('sub_menu', 'utility')->count() }}
                                    </h2>
                                </div>
                                <i class="fas fa-bolt fa-2x" style="color: #eab308; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow" style="border-left: 4px solid #22c55e;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1 small">Room</p>
                                    <h2 class="mb-0 font-weight-bold" style="color: #22c55e;">
                                        {{ $documents->where('sub_menu', 'room')->count() }}
                                    </h2>
                                </div>
                                <i class="fas fa-building fa-2x" style="color: #22c55e; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card shadow-lg mt-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('document-registration.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-weight-bold small">Filter by Category</label>
                                <select name="category" class="form-control" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    <option value="equipment"
                                        {{ request('category') == 'equipment' ? 'selected' : '' }}>Equipment</option>
                                    <option value="utility" {{ request('category') == 'utility' ? 'selected' : '' }}>
                                        Utility</option>
                                    <option value="room" {{ request('category') == 'room' ? 'selected' : '' }}>Room
                                    </option>
                                    <option value="computer" {{ request('category') == 'computer' ? 'selected' : '' }}>
                                        Computer System</option>
                                    <option value="process-mediafill"
                                        {{ request('category') == 'computer' ? 'selected' : '' }}>Process-mediafill
                                    </option>
                                    <option value="cleaning" {{ request('category') == 'cleaning' ? 'selected' : '' }}>
                                        Cleaning</option>
                                    <option value="analytical-method"
                                        {{ request('category') == 'analytical-method' ? 'selected' : '' }}>Analytical
                                        Method</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="font-weight-bold small">Filter by Document Type</label>
                                <select name="doc_type" class="select2 form-control" onchange="this.form.submit()">
                                    <option value="">All Types</option>
                                    <option value="Qualification Protocol"
                                        {{ request('doc_type') == 'Qualification Protocol' ? 'selected' : '' }}>
                                        Qualification Protocol</option>
                                    <option value="Calibration Report"
                                        {{ request('doc_type') == 'Calibration Report' ? 'selected' : '' }}>Calibration
                                        Report</option>
                                    <option value="Test Report"
                                        {{ request('doc_type') == 'Test Report' ? 'selected' : '' }}>Test Report
                                    </option>
                                    <option value="Installation Report"
                                        {{ request('doc_type') == 'Installation Report' ? 'selected' : '' }}>
                                        Installation Report</option>
                                    <option value="User Requirement Specification"
                                        {{ request('doc_type') == 'User Requirement Specification' ? 'selected' : '' }}>
                                        User Requirement Specification</option>
                                    <option value="Functional Design Specification"
                                        {{ request('doc_type') == 'Functional Design Specification' ? 'selected' : '' }}>
                                        Functional Design Specification</option>
                                    <option value="Design Specification"
                                        {{ request('doc_type') == 'Design Specification' ? 'selected' : '' }}>Design
                                        Specification</option>
                                    <option value="Risk Assessment"
                                        {{ request('doc_type') == 'Risk Assessment' ? 'selected' : '' }}>Risk Assessment
                                    </option>
                                    <option value="Installation Qualification Protocol"
                                        {{ request('doc_type') == 'Installation Qualification Protocol' ? 'selected' : '' }}>
                                        Installation Qualification Protocol</option>
                                    <option value="Operational Qualification Protocol"
                                        {{ request('doc_type') == 'Operational Qualification Protocol' ? 'selected' : '' }}>
                                        Operational Qualification Protocol</option>
                                    <option value="Performancance Qualification Protocol"
                                        {{ request('doc_type') == 'Performancance Qualification Protocol' ? 'selected' : '' }}>
                                        Performancance Qualification Protocol</option>
                                    <option value="Installation Qualification Report"
                                        {{ request('doc_type') == 'Installation Qualification Report' ? 'selected' : '' }}>
                                        Installation Qualification Report</option>
                                    <option value="Operational Qualification Report"
                                        {{ request('doc_type') == 'Operational Qualification Report' ? 'selected' : '' }}>
                                        Operational Qualification Report</option>
                                    <option value="Performance Qualification Report"
                                        {{ request('doc_type') == 'Performance Qualification Report' ? 'selected' : '' }}>
                                        Performance Qualification Report</option>
                                    <option value="Justification"
                                        {{ request('doc_type') == 'Justification' ? 'selected' : '' }}>Justification
                                    </option>
                                    <option value="Addendum" {{ request('doc_type') == 'Addendum' ? 'selected' : '' }}>
                                        Addendum</option>
                                    <option value="Periodic Review Report"
                                        {{ request('doc_type') == 'Periodic Review Report' ? 'selected' : '' }}>Periodic
                                        Review Report</option>
                                    <option value="Validation Study Protocol"
                                        {{ request('doc_type') == 'Validation Study Protocol' ? 'selected' : '' }}>
                                        Validation Study Protocol</option>
                                    <option value="Validation Study Report"
                                        {{ request('doc_type') == 'Validation Study Report' ? 'selected' : '' }}>
                                        Validation Study Report</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="font-weight-bold small">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                    placeholder="Search by doc number, equipment name...">
                            </div>

                            <div class="col-md-2">
                                <label class="font-weight-bold small">&nbsp;</label>
                                <div class="d-flex" style="gap: 0.5rem;">
                                    <button type="submit" class="btn btn-primary flex-fill">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="{{ route('document-registration.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-redo"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Documents Table -->
            <div class="card shadow-lg mt-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="fas fa-list mr-2"></i>Document List
                        </h5>
                        <!-- <button class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel mr-2"></i>Export to Excel
                        </button> -->
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th style="white-space: nowrap;">Doc Number</th>
                                <th>Document Type</th>
                                <th style="white-space: nowrap;">ID Number</th>
                                <th>Subject</th>
                                <th> Name</th>
                                <th>Category</th>
                                <th style="white-space: nowrap;">Upload Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                            <tr class="{{ !$doc->equipment ? 'table-danger' : '' }}">
                                <td class="font-weight-bold text-primary" style="white-space: nowrap;">
                                    {{ $doc->doc_number }}
                                </td>
                                <td>{{ $doc->document_type }}</td>
                                <td>
                                    {{ isset($doc->equipment->equipment_id) ? $doc->equipment->equipment_id : '' }}
                                    {{ isset($doc->equipment->product_code) ? $doc->equipment->product_code : '' }}
                                </td>
                                <td>{{ $doc->subject }}</td>
                                <!-- <td>{{ isset($doc->equipment) && isset($doc->equipment->equipment_name) ? $doc->equipment->equipment_name : 'Equipment Deleted' }} -->
                                <td>
                                    {{ $doc->equipment ? $doc->equipment->product_name : '' }} <br>
                                    {{ $doc->equipment ? $doc->equipment->equipment_name : '' }}
                                </td>

                                <td>
                                    @php
                                    $categoryConfig = [
                                    'equipment' => ['icon' => 'wrench', 'class' => 'info', 'label' => 'Equipment'],
                                    'utility' => ['icon' => 'bolt', 'class' => 'warning', 'label' => 'Utility'],
                                    'room' => ['icon' => 'building', 'class' => 'success', 'label' => 'Room'],
                                    'computer' => ['icon' => 'laptop', 'class' => 'primary', 'label' => 'Computer'],
                                    'cleaning' => ['icon' => 'spray-can', 'class' => 'secondary', 'label' =>
                                    'Cleaning'],
                                    ];
                                    $config = isset($categoryConfig[$doc->sub_menu]) ? $categoryConfig[$doc->sub_menu] :
                                    ['icon' => 'tag', 'class' => 'secondary', 'label' => ucfirst($doc->sub_menu)];
                                    @endphp
                                    <span class="badge badge-{{ $config['class'] }}">
                                        <i class="fas fa-{{ $config['icon'] }}"></i> {{ $config['label'] }}
                                    </span>
                                </td>
                                <td class="font-weight-bold" style="color: #22c55e; white-space: nowrap;">
                                    {{ \Carbon\Carbon::parse($doc->created_at)->format('Y-m-d') }}
                                </td>
                                <td class="text-center" style="white-space: nowrap;">
                                    <button class="btn btn-sm btn-info" title="View" onclick="viewPdf(this)"
                                        data-document-id="{{ $doc->id }}" data-document-number="{{ $doc->doc_number }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('documents.download', $doc->id) }}?t={{ time() }}"
                                        class="btn btn-sm btn-success" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" title="Delete"
                                        onclick="deleteDocument({{ $doc->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-5 text-center">
                                    <i class="fas fa-file-alt text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-3 mb-0">No documents yet. Click "Add New Document" to start.
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($documents->count() > 0)
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            Showing {{ $documents->firstItem() }} to {{ $documents->lastItem() }} of
                            {{ $documents->total() }} entries
                        </span>
                        <span class="text-muted">
                            {{ $documents->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </span>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<!-- Modal PDF Viewer -->
<div class="modal fade" id="pdfViewerModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">View Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="pdfFrame" width="100%" height="600px"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="documentModal" class="modal-custom">
    <div class="modal-custom-content">
        <!-- Modal Header -->
        <div class="bg-primary text-white p-3 d-flex justify-content-between align-items-center"
            style="border-bottom: 1px solid #dee2e6;">
            <div>
                <h5 class="mb-0 font-weight-bold" id="modalTitle">Step 1: Select Tools</h5>
                <p class="mb-0 small" style="opacity: 0.9;" id="modalSubtitle">Choose sub-menu and tools for
                    documentation</p>
            </div>
            <button type="button" class="btn btn-link text-white" onclick="closeModal()"
                style="font-size: 1.5rem; text-decoration: none;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-3">
            <!-- STEP 1: Select Tools -->
            <div id="step1" class="form-section active">
                <!-- Sub-Menu Dropdown -->
                <div class="mb-4">
                    <label class="font-weight-bold mb-2 d-block" style="font-size: 1.1rem;">
                        Select Sub-Menu <span class="text-danger">*</span>
                    </label>
                    <select id="subMenuSelect" class="form-control form-control-lg" onchange="handleSubMenuChange()">
                        <option value="">-- Select a Sub-Menu --</option>
                    </select>
                </div>

                <!-- Tools List -->
                <div id="toolsContainer" style="display: none;">
                    <label class="font-weight-bold mb-2 d-block" style="font-size: 1.1rem;">
                        Select Tools <span class="text-danger">*</span>
                    </label>

                    <!-- Search -->
                    <input type="text" id="toolsSearch" class="form-control form-control-sm mb-3"
                        placeholder="Search by ID or Name..." onkeyup="handleToolsSearch()">

                    <!-- Tools List -->
                    <div id="toolsList"
                        style="max-height: 16rem; overflow-y: auto; border: 2px solid #e5e7eb; border-radius: 0.5rem; padding: 1rem;">
                        <!-- Tools will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- STEP 2: Upload Document -->
            <div id="step2" class="form-section">
                <!-- Tool Info Card -->
                <h5>Document List</h5><span>
                    <p class="font-weight-bold" id="selectedToolsId"></p>
                </span>
                <table class="table table-bordered table-sm custom-small-table" id="documentTable">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Document Number</th>
                            <th>Document Type</th>
                            <th>Revision</th>
                            <th>Last Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan dimasukkan lewat JS -->
                    </tbody>
                </table>
                <!-- Document Details Form -->
                <form id="documentForm">
                    {{ csrf_field() }}
                    <input type="hidden" id="toolsIdInput" name="tools_id">
                    <input type="hidden" id="subMenuInput" name="sub_menu">
                    <h6 class="font-weight-bold mb-3 border-top pt-3">Document Details</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small mb-2">
                                    Document Type <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" name="document_type" id="documentType" required>
                                    <option value="">Select Type</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small mb-2">
                                    Document Number
                                </label>
                                <input type="text" class="form-control" style="font-weight: bold;" id="documentNumber"
                                    name="document_number" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small mb-2">
                                    Serial Number <span class="text-danger">*</span>
                                </label>
                                <select name="serialnumber" id="serial_number">
                                    @for ($i = 0; $i <= 100; $i++) <option value="{{ sprintf('%03d', $i) }}">
                                        {{ sprintf('%03d', $i) }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small mb-2">
                                    Revision Number
                                </label>
                                <select class="form-control" name="revision_number" id="revisionNumber" required>
                                    <option value="">Select Revision</option>
                                    @for ($i = 0; $i <= 100; $i++) <option value="{{ sprintf('%02d', $i) }}">
                                        {{ sprintf('%02d', $i) }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small mb-2">
                                    Requalification
                                </label>
                                <select class="form-control" name="requalification" id="requalification" required>
                                    <option value="">Select Requalification</option>
                                    @for ($i = 0; $i <= 100; $i++) <option value="{{ sprintf('%02d', $i) }}">
                                        {{ sprintf('%02d', $i) }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small mb-2">
                                    Model & Type <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="modelType" id="documentTitle"
                                    placeholder="Enter Model & Type">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small mb-2">
                                    Subject
                                </label>
                                <select class="form-control" name="subject" id="subject">
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small mb-2">
                                    Aprove Date
                                </label>
                                <input type="date" class="form-control" name="approvedate" id="aprovedateInput"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small mb-2">
                                    Frequensi Review
                                </label>
                                <select class="form-control" name="review_frequency" id="reviewFrequency">
                                    <option value="">Select Frequency</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">1 Year</option>
                                    <option value="24">2 Years</option>
                                    <option value="36">3 Years</option>
                                    <option value="48">4 Years</option>
                                    <option value="60">5 Years</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small mb-2">
                                    Next Review
                                </label>
                                <input type="date" class="form-control" name="nextreview" id="nextreviewInput" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="form-group border-top pt-3">
                        <label class="font-weight-bold small mb-3 d-block">
                            Upload File <span class="text-danger">*</span>
                        </label>
                        <div class="dropzone" id="dropzone" ondrop="handleDrop(event)"
                            ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                            onclick="document.getElementById('fileInput').click()">
                            <i class="fas fa-cloud-upload-alt"
                                style="font-size: 2rem; color: #4f46e5; margin-bottom: 0.5rem;"></i>
                            <p class="mb-1 font-weight-bold text-dark">Drag and drop file here</p>
                            <p class="mb-1 small text-muted">or click to browse</p>
                            <p class="mb-0 small text-muted">Supported: PDF, DOC, DOCX (Max 10 MB)</p>
                        </div>
                        <input type="file" id="fileInput" name="file" class="d-none" accept=".pdf,.doc,.docx"
                            onchange="handleFileSelect(event)" required>
                        <div id="fileInfo" style="display: none; margin-top: 1rem;">
                            <p class="text-success font-weight-bold">
                                <i class="fas fa-check-circle"></i> <span id="fileName"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="form-group">
                        <label class="font-weight-bold small mb-2">
                            Remarks
                        </label>
                        <textarea class="form-control" name="remarks" id="remarks" rows="3"
                            placeholder="Add any additional notes..."></textarea>
                    </div>

                </form>

            </div>
        </div>
        <!-- Modal Footer -->
        <div class="bg-light p-4 d-flex gap-2 justify-content-end" style="border-top: 1px solid #dee2e6;">
            <button type="button" id="backBtn" class="btn-secondary-custom" onclick="goToStep1()"
                style="display: none;">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </button>
            <button type="button" class="btn-secondary-custom" onclick="closeModal()">
                Cancel
            </button>
            <button type="button" id="nextBtn" class="btn-primary-custom" onclick="goToStep2()" disabled>
                Next <i class="fas fa-arrow-right ml-2"></i>
            </button>
            <button type="button" id="saveBtn" class="btn-success-custom" onclick="saveDocument()"
                style="display: none;">
                <i class="fas fa-spinner fa-spin mr-2" id="saveBtnSpinner" style="display: none;"></i>
                <i class="fas fa-save mr-2" id="saveBtnIcon"></i> Save Document
            </button>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let subMenus = [];
let toolsData = {};
let currentStep = 1;
let selectedSubMenu = '';
let selectedTools = []; // Array untuk menyimpan multiple tools yang dipilih
let selectedToolsData = []; // Array untuk menyimpan data tools yang dipilih
let selectedDocumentType = ''; // Untuk menyimpan document type yang dipilih
let usedDocumentTypes = [];
$(document).ready(function() {
    loadSubMenus();
});

function loadSubMenus() {
    $.ajax({
        url: '{{ route("documents.submenus") }}',
        method: 'GET',
        success: function(response) {
            subMenus = response;
            const select = $('#subMenuSelect');
            select.html('<option value="">-- Select a Sub-Menu --</option>');

            response.forEach(menu => {
                select.append(`<option value="${menu.id}">${menu.icon} ${menu.label}</option>`);
            });
        }
    });
}

//function load subject options based on sub menu
const menuMapping = {
    'equipment': ['Equipment'],
    'utility': ['PW', 'WFI', 'COAF', 'N2'],
    'room': [' '],
    'computer': ['System'],
    'process-mediafill': ['Product'],
    'cleaning': ['Equipment', 'Product'],
    'analytical-method': ['Product'],
    'default': ['General', 'Checklist', 'Report']
};
// Kosongkan dropdown

function loadSubjectOptions(subMenu) {
    const subjects = menuMapping[subMenu] || menuMapping['default'];
    subjects.forEach(subject => {
        $('#subject').append(new Option(subject, subject));
    });
}


function handleSubMenuChange() {
    selectedSubMenu = $('#subMenuSelect').val();
    selectedTools = [];
    selectedToolsData = [];
    const allowedTypes = ['Validation Report', 'Performance Qualification Report'];

    if (selectedSubMenu) {
        const menu = subMenus.find(m => m.id === selectedSubMenu);
        if (menu) {
            $('#categoryInfo').text(menu.category);
            $('#noDocInfo').text(menu.no_doc);
            $('#subMenuInfo').show();
            $('#subject').empty();
            loadToolsBySubMenu(selectedSubMenu);
            loadSubjectOptions(menu.id);
            toggleFrequencyReview(selectedSubMenu);
            $('#toolsContainer').show();
        }
    } else {
        $('#subMenuInfo').hide();
        $('#toolsContainer').hide();
        $('#toolsList').html('');
        $('#documentType').html('<option value="">Select Type</option>'); // Reset dropdown
        updateNextButton();
    }
}

function loadDocumentTypes(subMenu) {
    // Reset dropdown
    $('#documentType').html('<option value="">Select Type</option>');

    if (!subMenu) return;

    $.ajax({
        url: `/get-document-types/${subMenu}`,
        type: 'GET',
        success: function(response) {
            // console.log('Document types loaded:', response); // Debugging
            let availableCount = 0;
            response.forEach(docType => {
                availableCount++;

                // Filter: hanya tampilkan yang belum ada
                if (!usedDocumentTypes.includes(docType.type)) {
                    $('#documentType').append(
                        $('<option></option>')
                        .val(docType.type)
                        .text(`${docType.type} (${docType.no_doc})`)
                        .data('no_doc', docType.no_doc)
                    );
                }
            });

            // Tambahkan event handler untuk document type change
            $('#documentType').off('change').on('change', function() {
                updateDocumentNumber(); // panggil fungsi milikmu
                const selectedSubMenu = $('#subMenuSelect').val(); // ambil sub menu saat ini
                toggleFrequencyReview(selectedSubMenu); // kirim param
            });
        },
        error: function(xhr, status, error) {
            console.error('Error loading document types:', error);
            loadFallbackDocumentTypes(subMenu);
        }
    });
}


function loadToolsBySubMenu(subMenu) {
    $.ajax({
        url: `/api/documents/tools/${subMenu}`,
        method: 'GET',
        success: function(response) {
            console.log('Tools loaded for subMenu:', subMenu, response); // Debugging
            toolsData[subMenu] = response;
            renderToolsList(response);
        }
    });
}

function renderToolsList(tools) {
    const list = $('#toolsList');
    list.html('');

    if (tools.length === 0) {
        list.html('<p class="text-center text-muted">No tools available</p>');
        return;
    }

    // Render tools dengan checkbox untuk multiple selection
    tools.forEach(tool => {
        const isChecked = selectedTools.includes(tool.id.toString());
        const html = `
                <label class="tool-radio ${isChecked ? 'selected' : ''}">
                    <input type="checkbox" name="tools" value="${tool.id}" 
                           ${isChecked ? 'checked' : ''}
                           onchange="handleToolSelect('${tool.id}', '${tool.name}', '${tool.id_column}')">
                    <div class="tool-info">
                        <p class="mb-1 font-weight-bold">${tool.name}</p>
                        <p class="mb-0 small text-muted">${tool.id_column}</p>
                        <p class="mb-0 small text-muted">Building: ${tool.building} | Dept: ${tool.department}</p>
                    </div>
                    <span class="info-badge" style="background: #fef3c7; color: #92400e;">${tool.status} Document</span>
                </label>
            `;
        list.append(html);
    });
}

function handleToolSelect(toolId, toolName, toolIdColumn, subMenu) {
    selectedSubMenu = $('#subMenuSelect').val();
    const checkbox = event.target;
    const toolLabel = checkbox.closest('.tool-radio');
    
    if (checkbox.checked) {
        // Add tool to selected array
        if (!selectedTools.includes(toolId)) {
            selectedTools.push(toolId);
            const currentTools = toolsData[selectedSubMenu] || [];
            const toolData = currentTools.find(t => t.id == toolId);
            if (toolData) {
                selectedToolsData.push(toolData);
            }
        }
        toolLabel.classList.add('selected');
    } else {
        // Remove tool from selected array
        const index = selectedTools.indexOf(toolId);
        if (index > -1) {
            selectedTools.splice(index, 1);
            selectedToolsData.splice(index, 1);
        }
        toolLabel.classList.remove('selected');
    }
    
    updateNextButton();
    
    // Load document table for first selected tool
    if (selectedTools.length > 0) {
        loadDocumentTable(selectedTools[0], selectedSubMenu);
    }
}

function handleToolsSearch() {
    const searchText = $('#toolsSearch').val().toLowerCase();
    const currentTools = toolsData[selectedSubMenu] || [];

    const filtered = currentTools.filter(tool =>
        tool.name.toLowerCase().includes(searchText) ||
        tool.id_column.toLowerCase().includes(searchText)
    );

    renderToolsList(filtered);
}

function updateNextButton() {
    if (selectedSubMenu && selectedTools.length > 0) {
        $('#nextBtn').prop('disabled', false);
    } else {
        $('#nextBtn').prop('disabled', true);
    }
}


// Handle tool selection load document by selected tool
function loadDocumentTable(toolId, subMenu) {
    // Tampilkan loading state
    $('#documentTable tbody').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');

    $.ajax({
        url: `/document-tools/${toolId}/${subMenu}`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // console.log('Document data loaded:', subMenu,toolId, response); // Debugging
            if (response.success && response.data.length > 0) {
                populateTable(response.data);
                // Ambil daftar document_type yang sudah ada dari response
                usedDocumentTypes = response.data.map(item => item.document_type);
                loadDocumentTypes(subMenu);
            } else {
                $('#documentTable tbody').html(
                    '<tr><td colspan="6" class="text-center">No documents found</td></tr>');
                usedDocumentTypes = []; // kalau kosong
                loadDocumentTypes(subMenu);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            $('#documentTable tbody').html(
                '<tr><td colspan="6" class="text-center text-danger">Error loading data</td></tr>');
        }
    });
}
// Function to populate table with data document in table
function populateTable(data) {
    let tableBody = $('#documentTable tbody');
    tableBody.empty();

    data.forEach((item, index) => {
        let row = `
            <tr>
                <td>${index + 1}</td>
                <td>${item.doc_number || '-'}</td>
                <td>${item.document_type || '-'}</td>
                <td>${item.revision_number || '-'}</td>
                <td>${item.updated_at ? formatDate(item.updated_at) : '-'}</td>
                <td>
                         <button class="btn btn-sm btn-info" title="View"
                            onclick="viewPdf(this)"
                            data-document-id="${item.id}"
                            data-document-number="${item.doc_number}">
                            <i class="fas fa-eye"></i> View
                        </button>
                    ${item.document_file ? `
                    <button class="btn btn-sm btn-success download-doc" data-file="${item.document_file}">
                        <i class="fas fa-download"></i> Download
                    </button>
                    ` : ''}
                </td>
            </tr>
        `;
        tableBody.append(row);
    });
}
// Function untuk format tanggal
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

// Event handler untuk tombol view dan download
$(document).on('click', '.view-doc', function() {
    const docId = $(this).data('id');
    // Implement view functionality
    console.log('View document:', docId);
});

$(document).on('click', '.download-doc', function() {
    const filePath = $(this).data('file');
    // Implement download functionality
    window.open(`/download/${filePath}`, '_blank');
});


function goToStep2() {
    if (!selectedSubMenu || selectedTools.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Incomplete',
            text: 'Please select both sub-menu and at least one tool',
            confirmButtonColor: '#4f46e5'
        });
        return;
    }

    const menu = subMenus.find(m => m.id === selectedSubMenu);
    
    // Update document number berdasarkan tool pertama yang dipilih
    updateDocumentNumber();

    // Populate Step 2 with selected data - tampilkan semua tools yang dipilih
    const toolsIdText = selectedToolsData.map(t => t.id_column).join(', ');
    $('#selectedToolsId').text(toolsIdText);
    
    // Set hidden inputs dengan semua tool IDs (comma separated)
    $('#toolsIdInput').val(selectedTools.join(','));
    $('#subMenuInput').val(selectedSubMenu);

    // Switch steps
    currentStep = 2;
    $('#step1').removeClass('active');
    $('#step2').addClass('active');
    $('#nextBtn').hide();
    $('#saveBtn').show();
    $('#backBtn').show();

    $('#modalTitle').text('Step 2: Upload Document');
    $('#modalSubtitle').text(`Upload document details and file (${selectedTools.length} tool(s) selected)`);
}

function updateDocumentNumber() {
    const documentNumberElement = $('#documentNumber');

    // Ambil serial number yang dipilih
    const serialNumber = $('#serial_number').val();

    // Jika belum ada document type yang dipilih, set default
    const selectedDocType = $('#documentType option:selected');
    if (!selectedDocType.val()) {
        documentNumberElement.val('select type doc' + serialNumber);
        return;
    }

    // Ambil no_doc dari document type
    const noDoc = selectedDocType.data('no_doc');
    // console.log('Selected no_doc:', noDoc); // Debugging
    if (!noDoc) {
        // Allow editing the document number when no document type is selected
        documentNumberElement.prop('readonly', false);
        documentNumberElement.val('/' + serialNumber);
        return;
    }
    documentNumberElement.prop('readonly', true);

    // Gunakan data dari tool PERTAMA yang dipilih untuk generate document number
    if (selectedToolsData.length > 0 && selectedToolsData[0].building && selectedToolsData[0].department) {
        const building = selectedToolsData[0].building.substring(0, 3).toUpperCase();
        const dept = selectedToolsData[0].department.substring(0, 3).toUpperCase();
        const newDocumentNumber = `${noDoc}/${building}/${dept}/${serialNumber}`;
        documentNumberElement.val(newDocumentNumber);
    } else {
        // Jika belum ada tool yang dipilih, tampilkan no_doc + serial number saja
        documentNumberElement.val(noDoc + '/' + serialNumber);
    }
}
// Tambahkan event handler untuk serial number change
$('#serial_number').on('change', function() {
    updateDocumentNumber();
});

function goToStep1() {
    currentStep = 1;
    $('#step2').removeClass('active');
    $('#step1').addClass('active');
    $('#nextBtn').show();
    $('#saveBtn').hide();
    $('#backBtn').hide();

    $('#modalTitle').text('Step 1: Select Tools');
    $('#modalSubtitle').text('Choose sub-menu and tools for documentation');
}

function handleDragOver(event) {
    event.preventDefault();
    event.stopPropagation();
    $('#dropzone').addClass('dragover');
}

function handleDragLeave(event) {
    event.preventDefault();
    event.stopPropagation();
    $('#dropzone').removeClass('dragover');
}

function handleDrop(event) {
    event.preventDefault();
    event.stopPropagation();
    $('#dropzone').removeClass('dragover');

    const files = event.dataTransfer.files;
    if (files.length > 0) {
        $('#fileInput')[0].files = files;
        handleFileSelect({
            target: {
                files: files
            }
        });
    }
}

function handleFileSelect(event) {
    const file = event.target.files[0];
    if (file) {
        $('#fileName').text(file.name);
        $('#fileInfo').show();
    }
}

function saveDocument() {
    const formData = new FormData($('#documentForm')[0]);
    
    // Tambahkan semua selected tool IDs (sudah ada di toolsIdInput sebagai comma-separated)
    // formData sudah include toolsIdInput value dari form
    
    // Show spinner and disable button
    $('#saveBtnSpinner').show();
    $('#saveBtnIcon').hide();
    $('#saveBtn').prop('disabled', true);

    $.ajax({
        url: '{{ route("documents.store") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // Hide spinner and restore button
            $('#saveBtnSpinner').hide();
            $('#saveBtnIcon').show();
            $('#saveBtn').prop('disabled', false);
            
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: response.message || `Document saved successfully for ${selectedTools.length} tool(s)`,
                confirmButtonColor: '#4f46e5'
            }).then(() => {
                closeModal();
                location.reload();
            });
        },
        error: function(xhr) {
            // Hide spinner and restore button
            $('#saveBtnSpinner').hide();
            $('#saveBtnIcon').show();
            $('#saveBtn').prop('disabled', false);
            
            let errorMessage = 'An error occurred';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: errorMessage,
                confirmButtonColor: '#dc3545'
            });
        }
    });
}

function openModal() {
    currentStep = 1;
    selectedSubMenu = '';
    selectedTools = [];
    selectedToolsData = [];

    $('#documentModal').addClass('show');
    $('#step1').addClass('active');
    $('#step2').removeClass('active');
    $('#nextBtn').show();
    $('#saveBtn').hide();
    $('#backBtn').hide();
    $('#nextBtn').prop('disabled', true);

    $('#subMenuSelect').val('');
    $('#toolsContainer').hide();
    $('#subMenuInfo').hide();
    $('#toolsList').html('');
    $('#documentForm')[0].reset();
    $('#fileInfo').hide();
}

function closeModal() {
    $('#documentModal').removeClass('show');
}

function deleteDocument(id) {
    Swal.fire({
        title: 'Delete Document?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ route("documents.destroy", "") }}/${id}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.message,
                        confirmButtonColor: '#4f46e5'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Error deleting document',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }
    });
}

// Function untuk view PDF
function viewPdf(button) {
    const documentId = button.getAttribute('data-document-id');
    const docNumber = button.getAttribute('data-document-number');
    const pdfFrame = document.getElementById('pdfFrame');
    const modalTitle = document.getElementById('pdfModalLabel');

    // Ubah judul modal
    modalTitle.textContent = 'View Document - ' + docNumber;

    // Set iframe src (dengan cache-buster)
    pdfFrame.src = "{{ url('documents/view') }}/" + documentId + "?t=" + new Date().getTime();

    // Tampilkan modal
    const modal = new bootstrap.Modal(document.getElementById('pdfViewerModal'));
    modal.show();
}
// Fungsi pemicu ulang: ambil subMenu saat ini dan panggil fungsi utama
function toggleFrequencyReview(subMenu) {
    const allowedTypes = ['Validation Report', 'Performance Qualification Report'];
    const selectedType = $('#documentType').val();

    if (allowedTypes.includes(selectedType) ||
        (selectedType === 'Operational Qualification Report' && subMenu === 'computer')
    ) {
        $('#reviewFrequency').prop('disabled', false);
    } else {
        $('#reviewFrequency').prop('disabled', true).val('');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const approvedateInput = document.getElementById('aprovedateInput');
    const reviewFrequency = document.getElementById('reviewFrequency');
    const nextreviewInput = document.getElementById('nextreviewInput');

    function calculateNextReview() {
        const approvedate = new Date(approvedateInput.value);
        const frequency = parseInt(reviewFrequency.value);

        if (!approvedate || !frequency) {
            nextreviewInput.value = '';
            return;
        }

        const nextReviewDate = new Date(approvedate);
        nextReviewDate.setMonth(nextReviewDate.getMonth() + frequency);
        const formattedDate = nextReviewDate.toISOString().split('T')[0];
        nextreviewInput.value = formattedDate;
    }

    approvedateInput.addEventListener('change', calculateNextReview);
    reviewFrequency.addEventListener('change', calculateNextReview);
});
</script>
@endpush

@section('scripts')

@endsection