@extends('layouts.layout')

@section('title', 'Notification Due Date Instrument Calibration')
@section('styles')

@endsection
@section('content')
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next Calibration Schedule</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
    .header-card {
        background-color: #3959e7ff;
        color: white;
        border-radius: 15px;
    }

    .filter-card {
        background: #f8f9fa;
        border-radius: 10px;
        border: 1px solid #e9ecef;
    }

    .priority-overdue {
        background-color: #ffebee;
        border-left: 4px solid #f44336;
    }

    .priority-urgent {
        background-color: #fff3e0;
        border-left: 4px solid #ff9800;
    }

    .priority-soon {
        background-color: #fff8e1;
        border-left: 4px solid #ffc107;
    }

    .priority-normal {
        background-color: #f3e5f5;
        border-left: 4px solid #0dcaf0;
    }

    .priority-future {
        background-color: #e8f5e8;
        border-left: 4px solid #4caf50;
    }

    .priority-icon {
        font-size: 1.2em;
    }

    .stats-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.1);
    }

    .btn-schedule {
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        color: white;
    }

    .btn-schedule:hover {
        background: linear-gradient(45deg, #20c997, #28a745);
        color: white;
    }

    .days-remaining {
        font-weight: bold;
        font-size: 0.9em;
    }
</style>
</head>

<body class="bg-light">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card header-card shadow">
                    <div class="card-body text-center py-4">
                        <h2 class="mb-2">
                            <i class="fas fa-calendar-check me-3"></i>
                            Next Qualification Schedule
                        </h2>
                        <p class="mb-0 opacity-75">Jadwal Update Document yang Akan Datang</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row d-flex justify-content-center ">
            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <div class="card stats-card bg-danger text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                        <h4 class="mb-1"> {{ $countOverdue }} </h4>
                        <small>Overdue</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <div class="card stats-card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h4 class="mb-1"> {{ $countWarning }} </h4>
                        <small>7 Days</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <div class="card stats-card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-day fa-2x mb-2"></i>
                        <h4 class="mb-1"> {{ $countNormal }} </h4>
                        <small>30 Days</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <div class="card stats-card bg-purple text-white" style="background-color: #4caf50!important;">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                        <h4 class="mb-1"> {{ $countFuture }} </h4>
                        <small>60 + Days</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <div class="card stats-card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-tools fa-2x mb-2"></i>
                        <h4 class="mb-1">{{count($documents)}}</h4>
                        <small>Total</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-card p-4 mb-4">
            <form method="GET" class="mb-3">
    <!-- Rentang Bulan (di tengah atas) -->
    <div class="row justify-content-center mb-3">
        <div class="col-md-3">
            <label class="form-label fw-bold">
                <i class="fas fa-calendar-range me-1"></i>Rentang Bulan:
            </label>
            <div class="d-flex gap-2">
                <input type="month" class="form-control" name="start_month" value="{{ request('start_month') }}" placeholder="Mulai Bulan">
                <span class="d-flex align-items-center">s.d.</span>
                <input type="month" class="form-control" name="end_month" value="{{ request('end_month') }}" placeholder="Akhir Bulan">
            </div>
        </div>
    </div>

    <!-- Filter lainnya (di bawah) -->
     <div class="row justify-content-center align-items-end">
                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-search me-1"></i>Tool/Product:
                        </label>
                        <input type="text" class="form-control" name="search" value=""
                            placeholder="Nama atau kode alat...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-map-marker-alt me-1"></i>Category Menu:
                        </label>
                        <select class="form-select" name="sub_menu">
                            <option value="">All Category</option>
                            <option value="equipment" {{ request('sub_menu') === 'equipment' ? 'selected' : '' }} >
                                equipment</option>
                            <option value="utility" {{ request('sub_menu') === 'utility' ? 'selected' : '' }} >utility
                            </option>
                            <option value="room" {{ request('sub_menu') === 'room' ? 'selected' : '' }} >Room
                                Qualification</option>
                            <option value="computer" {{ request('sub_menu') === 'computer' ? 'selected' : '' }}>
                                Computerized System</option>
                            <option value="process-mediafill" {{ request('sub_menu') === 'process-mediafill' ? 'selected' : '' }}>
                                Process Mediafill
                            </option>
                            <option value="cleaning" {{ request('sub_menu') === 'cleaning' ? 'selected' : '' }} >Cleaning
                                Validation</option>
                            <option value="analytical-method" {{ request('sub_menu') === 'analytical-method' ? 'selected' : '' }}>
                                Analytical Method
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-map-marker-alt me-1"></i>Document Type:
                        </label>
                        <select class="form-select" name="doc_type">
                            <option value="">All Document Type</option>
                            <option value="Performance Qualification Report" {{ request('doc_type') === 'Performance Qualification Report' ? 'selected' : '' }}>
                                Performance Qualification Report</option>
                            <option value="Operational Qualification Report" {{ request('doc_type') === 'Operational Qualification Report' ? 'selected' : '' }}>
                                Operational Qualification Report</option>
                            <option value="Periodic Review" {{ request('doc_type') === 'Periodic Review' ? 'selected' : '' }}>
                                Periodic Review
                            </option>
                            <option value="Validation Report" {{ request('doc_type') === 'Validation Report' ? 'selected' : '' }}>
                                Validation Report
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-exclamation-circle me-1"></i>Priority:
                        </label>
                        <select class="form-select" name="priority">
                            <option value="">Semua Priority</option>
                            <option value="overdue" {{ request('priority') === 'overdue' ? 'selected' : '' }}>Overdue
                            </option>
                            <option value="warning" {{ request('priority') === 'warning' ? 'selected' : '' }}>Warning
                            </option>
                            <option value="normal" {{ request('priority') === 'normal' ? 'selected' : '' }}>Normal
                            </option>
                            <option value="future" {{ request('priority') === 'future' ? 'selected' : '' }}>Future
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <div class="d-flex gap-2">
                            <button type="submit" id="submitBtn" class="btn btn-primary">
                                <span id="submitText">Filter</span>
                                <span id="submitSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                            </button>
                            <a href="{{ route('documents.schedule') }}" class="btn btn-outline-secondary flex-fill">
                                <i class="fas fa-times me-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </div>
</form>
        </div>

        <!-- Action Buttons -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="btn-group">
                    <a href="#" class="btn btn-success"> <i class="fas fa-download me-1"></i>
                        Export to Excel
                    </a>
                    <a href="{{ route('documents.schedule', array_merge(request()->query(), ['print' => 1])) }}"
                        target="_blank" class="btn btn-info">
                        <i class="fas fa-print me-1"></i>Print
                    </a>
                    <!-- <form action="#" method="POST" id="send-email-form">
                        {{csrf_field()}}
                        <input type="hidden" name="link" id="current-link">
                        <button type="submit" class="btn btn-warning"> <i class="fas fa-bell me-1"></i>Send
                            Reminders</button>
                    </form> -->
                </div>
            </div>
        </div>

        <!-- Table View -->
        <div id="tableViewContent">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Jadwal Kalibrasi
                        </h5>
                        <span class="badge bg-light text-primary"> {{ count($documents) }} Total Data </span>
                        <span style="float: right;">
                            Generated: <span id="currentDate"></span>
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Priority</th>
                                    <th>Doc Number</th>
                                    <th>Tools/Product</th>
                                    @if($showRoomfields)
                                    <th>ServiceArea/Location</th>
                                    @endif
                                    <th>Last Review</th>
                                    <th>Due Date</th>
                                    <th>Days Remaining</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $item)
                                <tr
                                    class="{{ $item->next_review < \Carbon\Carbon::now() ? 'priority-overdue' : ($item->next_review <= \Carbon\Carbon::now()->addDays(7) ? 'priority-urgent' :  ($item->next_review <= \Carbon\Carbon::now()->addDays(60) ? 'priority-normal' : 'priority-future')) }}">
                                    <td>
                                        <i class="fas
                                            @if($item->next_review < \Carbon\Carbon::now())
                                                fa-exclamation-circle text-danger
                                            @elseif($item->next_review <= \Carbon\Carbon::now()->addDays(7))
                                                fa-exclamation-triangle text-warning
                                            @elseif($item->next_review <= \Carbon\Carbon::now()->addDays(60))
                                                fa-calendar-check text-info
                                            @else
                                                fa-check-circle text-success
                                            @endif
                                        "></i>
                                        <span class="ms-1">
                                            @if($item->next_review < \Carbon\Carbon::now()) <span
                                                class="badge bg-danger">Overdue</span>
                                        @elseif($item->next_review <= \Carbon\Carbon::now()->addDays(7))
                                            <span class="badge bg-warning text-dark">Warning</span>
                                            @elseif($item->next_review <= \Carbon\Carbon::now()->addDays(60))
                                                <span class="badge bg-info">Normal</span>
                                                @else
                                                <span class="badge bg-success">Future</span>
                                                @endif
                                                </span>
                                    </td>


                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $item->doc_number }}</strong><br>
                                                <small class="text-muted">{{ $item->document_type }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            {{ $item->equipment ? $item->equipment->equipment_id : '' }}
                                            {{ $item->equipment ? $item->equipment->product_code : '' }}<br>
                                            <small
                                                class="text-muted">{{$item->equipment ? $item->equipment->product_name : '' }} | {{$item->equipment ? $item->equipment->equipment_name : '' }} </small>
                                        </div>
                                    </td>
                                    @if($showRoomfields)
                                    <td>{{ $item->equipment ? $item->equipment->serviceArea : '' }} <br>
                                       <small class="text-muted">{{$item->equipment ? $item->equipment->location : '' }}</small>
                                </td>
                                    @endif
                                    <td>{{ \Carbon\Carbon::parse($item->approved_date)->format('d M Y') }}</td>
                                    <td>
                                        <strong
                                            class="{{ $item->next_review < \Carbon\Carbon::now() ? 'text-danger' : ($item->next_review <= \Carbon\Carbon::now()->addDays(7) ? 'text-warning' : ($item->next_review <= \Carbon\Carbon::now()->addDays(60) ? 'text-info' :  'text-success')) }}">
                                            {{ \Carbon\Carbon::parse($item->next_review)->format('d M Y') }}
                                        </strong>
                                    </td>
                                    <td>
                                        <span
                                            class="days-remaining {{ $item->next_review < \Carbon\Carbon::now() ? 'text-danger' : ($item->next_review <= \Carbon\Carbon::now()->addDays(7) ? 'text-warning' : ($item->next_review <= \Carbon\Carbon::now()->addDays(60) ? 'text-info' :  'text-success')) }}">
                                            {{ \Carbon\Carbon::parse($item->next_review)->diffInDays(\Carbon\Carbon::now()) }}
                                            days
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn-icon edit-btn" title="Edit"
                                                data-id="{{ $item->id }}"
                                                data-doc-number="{{ $item->doc_number }}"
                                                data-rev="{{ $item->revision_number }}"
                                                data-approved="{{ $item->approved_date }}"
                                                data-req="{{ $item->requalification }}"
                                                data-building="{{ $item->subject }}"
                                                data-nextreview="{{ $item->next_review }}"
                                                data-remark="{{ $item->remarks }}"
                                                data-category="{{ $item->sub_menu }}"
                                                data-equipment="{{ $item->equipment ? $item->equipment->equipment_id : '' }}"
                                                data-EquipmentName="{{ $item->equipment ? $item->equipment->equipment_name : '' }}"
                                                data-productcode="{{ $item->equipment ? $item->equipment->product_code : '' }}"
                                                data-productname="{{ $item->equipment ? $item->equipment->product_name : '' }}"
                                                data-createdDate="{{ $item->created_at }}"
                                                data-frequency="{{ $item->review_frequency }}"
                                                data-systemName="{{ $item->equipment ? $item->equipment->systemName : '' }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                            <a href="" class="btn btn-outline-info" title="View History">
                                                <i class="fas fa-history"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger delete-param"
                                                title="Delete Parameter" data-toggle="modal"
                                                data-target="#deleteParamModal" data-id="{{ $item->id }}"
                                                data-name="{{ $item->NoCalibration }}">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            Showing {{ $documents->firstItem() }} to {{ $documents->lastItem() }} of
                            {{ count($documents) }} entries
                        </span>
                        <span class="text-muted">
                            {{ $documents->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </span>
                    </div>
                </div>

            </div>
        </div>

    </div>
    </form>
<!-- Modal -->
<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit mr-2"></i>Update Document - <span id="modalDocNumber" class="font-weight-bold"></span>
                </h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
    <div class="modal-body">
                <form id="editForm" action="{{ route('document.update') }}" method="POST" enctype="multipart/form-data">
                   {{ csrf_field() }}
                    <input type="hidden" name="id" id="editId">
                <div class="row" style="margin-bottom: 10px;padding: 10px; background-color: #e8eaebff;" >
                    <div class="col-md-6">
                        <span class="font-weight-bold">ID Equipment :</span>
                        <span class="font-weight-semibold" id="editIdEquipment"></span>|
                        <span class="font-weight-semibold" id="editProductCode"></span>
                        <span class="font-weight-semibold" id="editSystemName"></span>
                    </div>
                    <div class="col-md-6">
                        <span class="font-weight-bold">Category:</span> 
                        <span class="font-weight-semibold" id="Category"></span>
                        
                    </div>
                    <div class="col-md-6">
                        <span class="font-weight-bold">Last Review:</span> 
                        <span class="font-weight-semibold" id="LastReview"></span>
                        
                    </div>
                    <div class="col-md-6">
                        <span class="font-weight-bold">Equipment Name :</span>
                        <span class="font-weight-semibold" id="editEquipmentName"></span>|
                        <span class="font-weight-semibold" id="editProductName"></span>
                    </div>
                    <div class="col-md-6">
                        <span class="font-weight-bold">Due Date :</span>
                        <span class="font-weight-semibold" id="DueDate"></span>
                    </div>
                    <div class="col-md-6">
                        <span class="font-weight-bold">Frequency Review:</span>
                        <span class="font-weight-semibold" id="editfrequencyReview"></span> Month 
                    </div>
                </div>
                <div class="row">
                        <!-- Doc Number -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editDocNumber" class="font-weight-semibold">
                                    Doc Number <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="doc_number" 
                                       id="editDocNumber" 
                                       class="form-control" 
                                       placeholder="Enter document number" readonly
                                       required>
                            </div>
                        </div>

                        <!-- Revision -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editRevision" class="font-weight-semibold">
                                    Revision <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" name="revision_number" id="editRevision">
                                    <option value="">Select Revision</option>
                                    @for ($i = 0; $i <= 100; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Requalification -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editRequalification" class="font-weight-semibold">
                                    Requalification <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" name="requalification" id="editRequalification">
                                    <option value="">Select Requalification</option>
                                    @for ($i = 0; $i <= 100; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- Approve Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editApproveDate" class="font-weight-semibold">
                                    Review Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       name="approve_date" 
                                       id="editApproveDate" 
                                       class="form-control"
                                       required>
                            </div>
                        </div>
                    </div>
                    <!-- hidden input review frequency -->
                    <input type="hidden" name="frequency_review" id="inputReviewFrequency">

                    <div class="row">
                        <!-- Next Review -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editNextReview" class="font-weight-semibold">
                                    Next Review <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       name="next_review" 
                                       id="editNextReview" 
                                       class="form-control" readonly>
                            </div>
                        </div>

                        <!-- Upload Document -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editUpload" class="font-weight-semibold">
                                    Upload Document
                                </label>
                                <div class="custom-file">
                                    <input type="file" 
                                           name="file" 
                                           id="editUpload" 
                                           class="custom-file-input"
                                           accept=".pdf,.doc,.docx,.xls,.xlsx">
                                    <label class="custom-file-label" for="editUpload">Choose file...</label>
                                </div>
                                <small class="form-text text-muted">Leave empty if you don't want to change the file</small>
                            </div>
                        </div>
                    </div>

                    <!-- Remark -->
                    <div class="form-group">
                        <label for="editRemark" class="font-weight-semibold">
                            Remark
                        </label>
                        <textarea name="remark" 
                                  id="editRemark" 
                                  class="form-control" 
                                  rows="3" 
                                  placeholder="Enter additional notes or remarks..."></textarea>
                        <small class="form-text text-muted">Optional: Add any additional information or notes</small>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer border-top pt-3 mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
<script>
// Ambil URL saat ini
let currentUrl = window.location.href;

// Tambahkan &print=1 atau ?print=1 jika belum ada query string
let printUrl = currentUrl.includes('?') ?
    currentUrl + '&print=1' :
    currentUrl + '?print=1';

// Set ke input hidden
document.getElementById('current-link').value = printUrl;
</script>
<script>
function printSchedule() {
    window.print();
}

document.getElementById('currentDate').textContent = new Date().toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
});

function sendReminders() {
    alert('Reminders sent successfully!');
}

document.querySelectorAll('.btn-check').forEach(btn => {
    btn.addEventListener('change', function() {
        const viewMode = this.id === 'tableView' ? 'table' : 'card';
        document.getElementById('tableViewContent').style.display = viewMode === 'table' ? 'block' :
            'none';
        document.getElementById('cardViewContent').style.display = viewMode === 'card' ? 'block' :
            'none';
    });
});

function scheduleCalibration(toolId) {
    alert(`Scheduling calibration for ${toolId}`);
}

function viewHistory(toolId) {
    alert(`Viewing history for ${toolId}`);
}

$(document).ready(function() {
    $('.delete-param').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        url = url.replace(':id', id);

        $('#deleteForm').attr('action', url);
        $('#param_id').val(id);
        $('#param_name').text(name);
    });
});
</script>




<script>
document.getElementById('filterForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');

    // Disable button
    submitBtn.disabled = true;
    // Change text
    submitText.textContent = 'Processing...';
    // Show spinner
    submitSpinner.classList.remove('d-none');
});
</script>

@endsection
@section('scripts')
<script>
    document.querySelectorAll('.edit-btn').forEach(button => {
        // console.log('button clicked');
        button.addEventListener('click', function() {
            console.log($(this).data());
            const id = $(this).data('id');
            const docNumber = $(this).data('doc-number');
            const revision = $(this).data('rev');
            const requalification = $(this).data('req');
            const approveDate = $(this).data('approved');
            const nextReview = $(this).data('nextreview');
            const remark = $(this).data('remark');
            const category = $(this).data('category');
            const equipment = $(this).data('equipment');
            const equipmentName = $(this).data('equipmentname');
            const productCode = $(this).data('productcode');
            const productName = $(this).data('productname');
            const createdDate = $(this).data('createddate');
            const updatedDate = $(this).data('updateddate');
            const frequency = $(this).data('frequency');
            const systemName = $(this).data('systemname');

            // isi field di modal
            $('#editId').val(id);
            $('#modalDocNumber').text(docNumber);
            $('#editDocNumber').val(docNumber);
            $('#editRevision').val(revision);
            $('#editRequalification').val(requalification);
            $('#LastReview').text(approveDate);
            $('#DueDate').text(nextReview);
            $('#editRemark').val(remark);
            $('#Category').text(category);
            $('#editIdEquipment').text(equipment);
            $('#editEquipmentName').text(equipmentName);
            $('#editProductCode').text(productCode);
            $('#editProductName').text(productName);
            $('#editCreatedDate').text(createdDate);
            $('#editUpdatedDate').text(updatedDate);
            $('#editfrequencyReview').text(frequency);
            $('#editSystemName').text(systemName);
            $('#inputReviewFrequency').val(frequency);
            // Show modal
            $('#editModal').modal('show');
        });
    });
// Next Review Calculation in modal
    $('#editApproveDate').on('change', function() {
        console.log($(this).val());
        const approvedate = new Date($(this).val());
        const frequency = parseInt($('#editfrequencyReview').text());
        const nextReviewDate = new Date(approvedate);
        nextReviewDate.setMonth(nextReviewDate.getMonth() + frequency);
        console.log(nextReviewDate);
        $('#editNextReview').val(nextReviewDate.toISOString().split('T')[0]);
    });

    //reset modal
    $('#editModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
    });

    // Update custom file input label with selected filename
    $('#editUpload').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Choose file...');
    });
</script>
@endsection