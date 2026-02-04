@extends('layouts.layout')
@section('styles')
    <style>


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
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .results-header {
        background: linear-gradient(135deg, #384277ff 0%, #5c7affff 100%);
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .results-title {
        color: white;
        font-size: 20px;
        font-weight: 700;
        margin: 0;
    }
    
    .export-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .btn-export {
        background: #28a745;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        color: white;
        text-decoration: none;
    }
    
    .tool-header {
        background: #f8f9fa;
        border-bottom: 3px solid #667eea;
        padding: 20px 25px;
    }
    
    .tool-id {
        font-size: 22px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }
    
    .tool-name {
        font-size: 16px;
        color: #7f8c8d;
        margin: 5px 0 0 0;
    }
    
    .tool-info {
        display: inline-block;
        background: #e9ecef;
        padding: 5px 12px;
        border-radius: 5px;
        font-size: 13px;
        color: #495057;
        margin-top: 10px;
    }
    
    .category-section {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        margin: 20px 25px;
        overflow: hidden;
    }
    
    .category-header {
        background: #f8f9fa;
        padding: 15px 20px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.3s;
    }
    
    .category-header:hover {
        background: #e9ecef;
    }
    
    .category-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .category-name {
        font-size: 18px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
        text-transform: uppercase;
    }
    
    .doc-count {
        background: #667eea;
        color: white;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .category-body {
        display: none;
    }
    
    .category-body.show {
        display: block;
    }
    
    .doc-table {
        width: 100%;
        margin: 0;
    }
    
    .doc-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    
    .doc-table th {
        padding: 12px 15px;
        font-size: 13px;
        font-weight: 700;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .doc-table tbody tr {
        border-bottom: 1px solid #dee2e6;
        transition: background 0.2s;
    }
    
    .doc-table tbody tr:hover {
        background: #f8f9fa;
    }
    
    .doc-table td {
        padding: 15px;
        vertical-align: middle;
    }
    
    .doc-no {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
    }
    
    .doc-type {
        color: #495057;
    }
    
    .date-cell {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #6c757d;
        font-size: 14px;
    }
    
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        border: 1px solid;
    }
    
    .badge-danger {
        background: #fee;
        color: #c00;
        border-color: #fcc;
    }
    
    .badge-warning {
        background: #fff3cd;
        color: #856404;
        border-color: #ffeaa7;
    }
    
    .badge-info {
        background: #d1ecf1;
        color: #0c5460;
        border-color: #bee5eb;
    }
    
    .badge-success {
        background: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }
    
    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: #7f8c8d;
    }
    
    .no-data h4 {
        font-size: 28px;
        margin-bottom: 10px;
    }
    
    .alert-custom {
        border-radius: 8px;
        border-left: 4px solid;
        margin-bottom: 20px;
    }
    
    .info-box {
        padding: 15px 25px;
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }
    
    .info-text {
        color: #6c757d;
        font-size: 14px;
        margin: 0;
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
    <div class="timeline-container">
    <div class="container">
        <!-- Search Box -->
        <div class="search-box">
            <h2 class="search-title"><i class="fas fa-search"></i> Equipment Timeline Viewer</h2>
            <p class="search-subtitle">Tracking dokumen dan jadwal review untuk setiap equipment</p>
            
            @if(session('error'))
                <div class="alert alert-danger alert-custom">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-custom">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            
            <form action="#" method="GET">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group mb-0">
                            <input type="text" 
                                   name="search" 
                                   class="form-control form-control-lg" 
                                   placeholder="Masukkan Equipment ID (contoh: PR-IA-BWF2-01)"
                                   value="{{ request('search') }}"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>

 @if(isset($tools))
    <div class="results-container">
        <div class="results-header">
            <h3 class="results-title"> <i class="fas fa-file-alt"></i> Document Report</h3>
            <!-- <div class="export-buttons">
                <a href="#"
                    class="btn-export"> <i class="fas fa-file-excel"></i>
                    Export to Excel
                </a>
                <a href="#"
                    class="btn-export" style="background: #dc3545;" target="_blank">
                     <i class="fas fa-print"></i>
                     Print Report
                </a>

            </div> -->
        </div>
            <div class="tool-header">
                <h4 class="tool-id">{{ $tools->first()->equipment_id }}</h4>
                <p class="tool-name">{{ $tools->first()->equipment_name }}</p>
                @if($tools->first()->product_code)
                    <span class="tool-info">
                        <i class="fas fa-barcode"></i> Product Code: {{ $tools->first()->product_code }}
                    </span>
                @endif
            </div>

            <div class="info-box">
                <p class="info-text">
                    <strong>Total Categories:</strong> {{ $tools->count() }} kategori | 
                    <strong>Total Documents:</strong> {{ $tools->sum(function($tool) { return $tool->documents->count(); }) }} dokumen | 
                    <span style="float: right;">
                        <strong>Generated:</strong> {{ date('d F Y, H:i') }} WIB
                    </span>
                </p>
            </div>

            <!-- Loop through each submenu/category -->
            @foreach($tools as $index => $toolCategory)
            <div class="category-section">
                <div class="category-header" onclick="toggleCategory({{ $index }})">
                    <div class="category-title">
                        <i class="fas fa-chevron-down" id="icon-{{ $index }}"></i>
                        <h5 class="category-name">{{ strtoupper($toolCategory->sub_menu) }}</h5>
                        <span class="doc-count">{{ $toolCategory->documents->count() }} dokumen</span>
                    </div>
                </div>
                
                <div class="category-body show" id="category-{{ $index }}">
                    <table class="doc-table table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 15%;">NO DOC</th>
                                <th style="width: 30%;">TYPE DOC</th>
                                <th style="width: 15%;">APPROVE DATE</th>
                                <th>REV</th>
                                <th>REQ</th>
                                <th style="width: 15%;">NEXT REVIEW</th>
                                <th style="width: 12%;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($toolCategory->documents as $document)
                            <tr>
                                <td style="white-space: nowrap;">
                                    <div class="doc-no">
                                        <i class="fas fa-file-alt text-muted"></i>
                                        {{ $document->doc_number }}
                                    </div>
                                </td>
                                <td class="doc-type">{{ $document->document_type }}</td>
                                <td>
                                    @if(isset($document->approved_date))
                                    <div class="date-cell">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($document->approve_date)->format('d M Y') }}
                                    </div>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $document->revision_number }}</td>
                                <td>{{ $document->requalification }}</td>
                                <td>
                                    @if(isset($document->next_review))
                                    <div class="date-cell">
                                        <i class="far fa-calendar-check"></i>
                                        {{ \Carbon\Carbon::parse($document->next_review)->format('d M Y') }}
                                    </div>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($document->next_review))
                                        @php
                                            $today = \Carbon\Carbon::now();
                                            $reviewDate = \Carbon\Carbon::parse($document->next_review);
                                            $daysUntilReview = $today->diffInDays($reviewDate, false);
                                            
                                            if ($daysUntilReview < 0) {
                                                $statusClass = 'danger';
                                                $statusLabel = 'Overdue';
                                            } elseif ($daysUntilReview < 30) {
                                                $statusClass = 'warning';
                                                $statusLabel = $daysUntilReview . ' hari lagi';
                                            } elseif ($daysUntilReview < 90) {
                                                $statusClass = 'info';
                                                $statusLabel = $daysUntilReview . ' hari lagi';
                                            } else {
                                                $statusClass = 'success';
                                                $statusLabel = 'On Track';
                                            }
                                        @endphp
                                        <span class="status-badge badge-{{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    <i class="fas fa-inbox"></i> Tidak ada dokumen
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
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
<script>
function toggleCategory(index) {
    const body = document.getElementById('category-' + index);
    const icon = document.getElementById('icon-' + index);
    
    if (body.classList.contains('show')) {
        body.classList.remove('show');
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-right');
    } else {
        body.classList.add('show');
        icon.classList.remove('fa-chevron-right');
        icon.classList.add('fa-chevron-down');
    }
}
</script>
@endsection