@extends('layouts.layout')
@section('styles')
    <style>
    .calibration-container {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .form-header {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .form-row {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        gap: 15px;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        min-width: 180px;
        text-align: right;
    }

    .form-input {
        flex: 1;
    }

    .form-input select,
    .form-input input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .btn-search {
        background: #007bff;
        color: white;
        padding: 10px 30px;
        border: none;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-search:hover {
        background: #0056b3;
        transform: translateY(-1px);
    }

    .btn-export {
        background: #28a745;
        color: white;
        padding: 8px 20px;
        border: none;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        margin-right: 10px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-export:hover {
        background: #1e7e34;
        color: white;
        text-decoration: none;
    }

    .results-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .results-header {
        background: #007bff;
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: between;
        align-items: center;
    }

    .results-title {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .export-buttons {
        display: flex;
        gap: 10px;
    }

    .calibration-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .calibration-table th {
        background: #f8f9fa;
        padding: 12px 8px;
        text-align: center;
        font-weight: 600;
        border: 1px solid #dee2e6;
        color: #495057;
        white-space: nowrap;
    }

    .calibration-table td {
        padding: 10px 8px;
        border: 1px solid #dee2e6;
        text-align: center;
        vertical-align: middle;
    }

    .calibration-table tbody tr:nth-child(even) {
        background: #f8f9fa;
    }

    .calibration-table tbody tr:hover {
        background: #e3f2fd;
    }

    .status-internal {
        background: #d4edda;
        color: #155724;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-external {
        background: #fff3cd;
        color: #856404;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .date-highlight {
        font-weight: 600;
        color: #dc3545;
    }

    .equipment-code {
        font-family: 'Courier New', monospace;
        background: #e9ecef;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 12px;
    }

    .no-data {
        text-align: center;
        padding: 40px;
        color: #6c757d;
        font-style: italic;
    }

    /* Print Styles */
    @media print {
        body {
            font-size: 12px;
            line-height: 1.3;
        }

        .form-header,
        .btn-search,
        .export-buttons {
            display: none !important;
        }

        .results-container {
            box-shadow: none;
            border: 1px solid #000;
        }

        .results-header {
            background: #000 !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
        }

        .calibration-table {
            font-size: 10px;
        }

        .calibration-table th {
            background: #f0f0f0 !important;
            -webkit-print-color-adjust: exact;
        }

        .calibration-table tbody tr:nth-child(even) {
            background: #f8f8f8 !important;
            -webkit-print-color-adjust: exact;
        }

        @page {
            margin: 0.5in;
            size: A4 landscape;
        }
    }
    </style>
@endsection

@section('content')
<div class="calibration-container">
    <!-- //current route -->
    <form method="GET" action="{{ url()->current()}}">
        <div class="form-header">
            <h4 style="margin-bottom: 20px; color: #495057;">Report Document by Document Filter</h4>


            <div class="form-row">
                <div class="form-label">Category:</div>
                <div class="form-input">
                    <select class="select" id="category" name="category">
                        <option value=" ">- Select Category -</option>   
                        <option value="equipment" {{ request('category') == 'equipment' ? 'selected' : '' }}>Equipment</option>
                        <option value="computer" {{ request('category') == 'computer' ? 'selected' : '' }}>Computerized</option>    
                        <option value="room" {{ request('category') == 'room' ? 'selected' : '' }}>Room</option>    
                        <option value="utility" {{ request('category') == 'utility' ? 'selected' : '' }}>Utility</option>    
                        <option value="process-mediafill" {{ request('category') == 'process-mediafill' ? 'selected' : '' }}>Process Media Fill</option>
                        <option value="cleaning" {{ request('category') == 'cleaning' ? 'selected' : '' }}>Cleaning</option>         
                        <option value="analytical-method" {{ request('category') == 'analytical-method' ? 'selected' : '' }}>Analitycal Method</option>     
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label">Type of Document:</div>
                <div class="form-input">
                    <select class="select" name="document_type" id="documentType">
                        <option value=" ">- ALL Type -
                        </option>
                      
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label">Building:</div>
                <div class="form-input">
                    <select class="select" id="building" name="building">
                        <option value="">- ALL BUILDINGS -
                        </option>
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
            <div class="form-row">
                <div class="form-label">Department:</div>
                <div class="form-input">
                    <select class="select" id="department" name="department" class="form-control">
                        <option value="">- ALL DEPARTMENTS -
                        </option>
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
            <div class="form-row">
                <div class="form-label">Dosage Form Code :</div>
                <select class="select2" id="Dosage" name="dosage" class="form-control">
                    <option value=" ">- ALL Dosage -
                    </option>
                                    <option value="INA" {{ request('dosage') == 'INA' ? 'selected' : '' }} >INA (Injection)</option>
                                    <option value="INV" {{ request('dosage') == 'INV' ? 'selected' : '' }} >INV (Sterile Injection Powder)</option>
                                    <option value="KPS" {{ request('dosage') == 'KPS' ? 'selected' : '' }} >KPS (Capsule)</option>
                                    <option value="KPT" {{ request('dosage') == 'KPT' ? 'selected' : '' }} >KPT (Caplet)</option>
                                    <option value="TAB" {{ request('dosage') == 'TAB' ? 'selected' : '' }} >TAB (Tablet)</option>
                                    <option value="OIL" {{ request('dosage') == 'OIL' ? 'selected' : '' }} >OIL (Cream)</option>s
                                    <option value="SYK" {{ request('dosage') == 'SYK' ? 'selected' : '' }} >SYK (Syrup)</option>
                                    <option value="SYR" {{ request('dosage') == 'SYR' ? 'selected' : '' }} >SYR (Syrup)</option>
                                    <option value="SUP" {{ request('dosage') == 'SUP' ? 'selected' : '' }} >SUP (Suppositorita/Ovula)</option>
                </select>
            </div>
            <div class="form-row">
                <div class="form-label">Identity Number:</div>
                <div class="form-input">
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="Input Identity Number...">
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"></div>
                <div class="form-input">
                    <button type="submit" class="btn-search"><i class="fas fa-search"></i> Search Data</button>
                </div>
            </div>
        </div>
    </form>
 @if(isset($documents) && $documents->isNotEmpty())
    <div class="results-container">
        <div class="results-header">
            <h3 class="results-title"> <i class="fas fa-file-alt"></i> Document Report</h3>
            <div class="export-buttons">
                <a href="{{ route('documents.exportExcel', request()->query()) }}"
                    class="btn-export" target="_blank"><i class="fas fa-file-excel"></i>
                    Export to Excel
                </a>
                <a href="{{ route('documents.report', request()->query()) }}"
                    class="btn-export" style="background: #dc3545;" target="_blank">
                    <i class="fas fa-print"></i>
                    Print Report
                </a>

            </div>

        </div>

        <div style="padding: 20px;">
            <div style="margin-bottom: 15px; color: #6c757d;">
                <strong>Total Records:</strong> {{ $documents   ->count() }} items found
                <span style="float: right;">
                    <strong>Generated:</strong> {{ date('d F Y, H:i') }} WIB
                </span>
            </div>

            <table class="calibration-table">
                <thead>
                    <tr>
                        <th> Identity Number </th>
                        <th> Building </th>
                        <th> Department /Dosage </th>
                        <th> Name </th>
                        <th> Document Number </th>
                        <th> Document type </th>
                        <th> Remarks </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $index => $masterData)
                    <tr>
                        <td><span class="equipment-code">{{ $masterData->equipment ? $masterData->equipment->equipment_id : 'No Master' }} {{ $masterData->equipment ? $masterData->equipment->product_code : '' }} </span></td>
                        <td>{{ $masterData->equipment ? $masterData->equipment->building : '' }}</td>
                        <td>{{ $masterData->equipment ? $masterData->equipment->department : '' }} {{ $masterData->equipment ? $masterData->equipment->dosageCode : '' }}</td>
                        <td style="text-align: left; padding-left: 10px;">{{ $masterData->equipment ? $masterData->equipment->equipment_name :'' }} {{ $masterData->equipment ? $masterData->equipment->product_name :'' }}</td>
                        <td><span class="equipment-code">{{ $masterData->doc_number }}</span></td>
                        <td>{{ $masterData->document_type}}</td>
                        <td> {{$masterData->remarks}}</td>
                        <!-- view data using modal -->
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-info btn-sm" title="View" data-toggle="modal"
                                    data-target="#detailModal" data-result="{{ $masterData->Result }}"
                                    data-createdby="{{ $masterData->updated_by }}" data-id="{{ $masterData->ToolsId }}">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger delete-param"
                                    title="Delete Parameter" data-toggle="modal" data-target="#deleteParamModal"
                                    data-id="{{ $masterData->id }}" data-name="{{ $masterData->NoCalibration }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="no-data">
                            📋 No calibration parameter data found with current filter criteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- //pagination  -->
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
    @else
    <div class="results-container">
        <div class="no-data">
            <h4>📋 No Data Available</h4>
            <p>Please use the filter above to search for calibration parameter data.</p>
        </div>
    </div>
    @endif

</div>
 @endsection   

@section('scripts')
<script>
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
                response.forEach(menu => {
                    select.append(`<option value="${menu.id}">${menu.icon} ${menu.label}</option>`);
                });
            }
        });
    }
</script>
@endsection