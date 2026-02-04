@extends('layouts.layout')

@section('content')

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }


    .container {
        max-width: 1400px;
        margin: 0 auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            border-bottom: 2px solid #e0e0e0;
        }

        .header h1 {
            font-size: 24px;
            color: #333;
        }

        .header-subtitle {
            color: #666;
            font-size: 14px;
            margin-top: 4px;
        }

        .close-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: none;
            font-size: 24px;
            color: #666;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .close-btn:hover {
            background-color: #f0f0f0;
        }

        .section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }

        /* Tool Details Grid */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
            font-weight: bold;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .detail-value {
            color: #333;
            font-size: 15px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 500;
            width: fit-content;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            margin-top: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        thead {
            background-color: #f8f9fa;
        }

        th {
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            font-size: 14px;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            color: #333;
            font-size: 14px;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            padding: 6px 12px;
            border: 1px solid #d1d5db;
            background-color: white;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-icon:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
        }

        .btn-icon.primary {
            background-color: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .btn-icon.primary:hover {
            background-color: #1d4ed8;
        }

        /* Form Styles */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        label .required {
            color: #dc2626;
        }

        select,
        input[type="text"],
        input[type="date"] {
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            color: #333;
            background-color: white;
            transition: border-color 0.2s;
        }

        select:focus,
        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .document-number-display {
            padding: 10px 12px;
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            color: #6b7280;
            font-family: monospace;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            padding-top: 20px;
            margin-top: 20px;
            border-top: 2px solid #e0e0e0;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #22c55e;
            color: white;
        }

        .btn-primary:hover {
            background-color: #16a34a;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        .collapse-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }

        .collapse-header:hover {
            opacity: 0.8;
        }

        .toggle-icon {
            font-size: 20px;
            transition: transform 0.3s;
        }

        .toggle-icon.collapsed {
            transform: rotate(-90deg);
        }

        .collapsible-content {
            max-height: 2000px;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .collapsible-content.collapsed {
            max-height: 0;
        }

        @media (max-width: 768px) {
            .details-grid {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

<body>
    @php
    $totalDocs = count($document->documents);
    $totalTypes = count($documentTypes);
    @endphp

    <div class="container">
        <div class="header">
            <div>
                <h1>{{$document->equipment_id}} {{$document->product_code}} | {{$document->equipment_name}}</h1>
                <div class="header-subtitle">{{$document->sub_menu}}</div>
            </div>
            <button class="close-btn" onclick="window.close()">×</button>
        </div>
        <div class="content">
            <!-- Tool Details Section -->
            <div class="section">
                <h2 class="section-title">Tool Details</h2>
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="detail-label">ID</span>
                        <span class="detail-value"> {{$document->equipment_id}} {{$document->product_code}}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Name</span>
                        <span class="detail-value">{{$document->equipment_name}}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Category</span>
                        <span class="detail-value">{{$document->sub_menu}}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Last Updated</span>
                        <span class="detail-value">{{$document->updated_at}}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Total Documents</span>
                        <span class="detail-value">{{ $totalDocs }}/{{ $totalTypes }} Documents</span>
                    </div>
                </div>
            </div>
            <!-- Document List Section -->
            <div class="section">
                <h2 class="section-title">Associated Documents</h2>
                <div style="display:flex;justify-content:flex-end;margin-bottom:12px;">
                    <button type="button" class="btn btn-primary" id="openFormBtn" data-target="#formContent"
                        onclick="openFormContent(this)">
                        ➕ Add New Document
                    </button>
                </div>

                <script>
                function openFormContent(btn) {
                    const target = btn.getAttribute('data-target');
                    if (!target) return;
                    const el = document.querySelector(target);
                    if (!el) return;
                    el.classList.remove('collapsed');
                    const icon = document.getElementById('toggleIcon');
                    if (icon) icon.classList.remove('collapsed');
                    el.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
                </script>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Document Number</th>
                                <th>Document Type</th>
                                <th style="width: 100px;">Revision</th>
                                <th style="width: 100px;">Requalification</th>
                                <th style="width: 120px;">Last Updated</th>
                                <th>Next Review</th>
                                <th style="width: 200px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="documentTableBody">
                            @foreach($document->documents as $doc)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$doc->doc_number}}</td>
                                <td>{{$doc->document_type}}</td>
                                <td> {{$doc->revision_number}} </td>
                                <td> {{$doc->requalification}} </td>
                                <td>{{ $doc->updated_at->format('d/m/Y') }}</td>
                                <td>{{$doc->next_review}}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon primary view-pdf" data-document-id="{{ $doc->id }}"
                                                data-document-number="{{ $doc->doc_number }}">
                                            <i class="fas fa-eye"></i>
                                            <span>View</span>
                                        </button>
                                        <a href="{{ route('documents.download', $doc->id) }}?t={{ time() }}"
                                        class="btn-icon" title="Download">
                                        <i class="fas fa-download"></i>
                                        </a>
                                        <button class="btn-icon edit-btn" title="Edit"
                                                data-id="{{ $doc->id }}"
                                                data-doc-number="{{ $doc->doc_number }}"
                                                data-rev="{{ $doc->revision_number }}"
                                                data-approved="{{ $doc->approved_date }}"
                                                data-req="{{ $doc->requalification }}"
                                                data-building="{{ $doc->subject }}"
                                                data-nextreview="{{ $doc->next_review }}"
                                                data-remark="{{ $doc->remarks }}"
                                                data-frequency="{{ $doc->review_frequency }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                         <a href="{{ route('documents.history', $doc->id) }}" 
                                                 class="btn btn-sm btn-info" title="View History">
                                            <i class=" fas fa-history"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

            <!-- Add New Document Section -->
             <div class="container">
                <div class="content">
            <div class="section">
                <div class="d-flex justify-content-between align-items-center cursor-pointer"
                    onclick="toggleCollapse()">
                    <h2 class="h4 mb-0">Add New Document</h2>
                    <span class="toggle-icon" id="toggleIcon">▼</span>
                </div>
                <div class="collapsible-content mt-3" id="formContent">
                    <form id="documentForm">
                        <input type="hidden" name="tools_id" value="{{ $document->id }}">
                        <input type="hidden" name="sub_menu" value="{{ $document->sub_menu }}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label class="font-weight-bold">Document Type <span
                                                class="text-danger">*</span></label>
                                        <select id="documentType" name="document_type" class="form-control" required>
                                            <option value="">Select Type</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="font-weight-bold">Serial Number <span
                                                class="text-danger">*</span></label>
                                        <select id="serial_number" name="serial_number" class="form-control" required>
                                            <option value="">Select Serial</option>
                                            @for ($i = 0; $i <= 100; $i++) <option value="{{ sprintf('%03d', $i) }}">
                                                {{ sprintf('%03d', $i) }}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Document Number</label>
                                <input type="text" class="form-control font-weight-bold document-number-display"
                                    id="documentNumber" name="document_number" readonly value="DOC-001-003">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold">Revision Number</label>
                                <select class="form-control" name="revision_number" id="revisionNumber" required>
                                    <option value="">Select Revision</option>
                                    @for ($i = 0; $i <= 100; $i++) <option value="{{ sprintf('%02d', $i) }}">
                                        {{ sprintf('%02d', $i) }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold">Requalification</label>
                                <select class="form-control" name="requalification" id="requalification" required>
                                    <option value="">Select Requalification</option>
                                    @for ($i = 0; $i <= 100; $i++) <option value="{{ sprintf('%02d', $i) }}">
                                        {{ sprintf('%02d', $i) }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold">Model & Type</label>
                                <input type="text" id="modelType" name="modelType" class="form-control"
                                    placeholder="Enter Model & Type">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold">Subject</label>
                                <select class="form-control" name="subject" id="subject" required>
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold">Approve Date</label>
                                <input type="date" id="approveDate" name="approvedate" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold">Frequency Review</label>
                                <select id="frequencyReview" name="review_frequency" class="form-control">
                                    <option value="">Select Frequency</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">1 Year</option>
                                    <option value="24">2 Years</option>
                                    <option value="36">3 Years</option>
                                    <option value="48">4 Years</option>
                                    <option value="60">5 Years</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold">Next Review</label>
                                <input type="date" id="nextReview" name="nextreview" class="form-control" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold">Upload Document <span
                                        class="text-danger">*</span></label>
                                <input type="file" id="fileInput" name="file" class="form-control"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold">Remarks</label>
                                <input type="text" id="remarks" name="remarks" class="form-control"
                                    placeholder="Enter Remarks">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                            <button type="submit" class="btn btn-primary" id="saveBtn">💾 Save
                                Document</button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
            </div>

            <!-- Modal PDF Viewer -->
            <div class="modal fade" id="pdfViewerModal" tabindex="-1" aria-labelledby="pdfModalLabel"
                aria-hidden="true">
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

</body>

 <!-- Edit Modal -->
<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit mr-2"></i>Edit Document - <span id="modalDocNumber" class="font-weight-bold"></span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="editForm" action="{{ route('document.update') }}" method="POST" enctype="multipart/form-data">
                   {{ csrf_field() }}
                    <input type="hidden" name="id" id="editId">

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
                                       placeholder="Enter document number"
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
                                    Approve Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       name="approve_date" 
                                       id="editApproveDate" 
                                       class="form-control"
                                       required>
                            </div>
                        </div>
                    </div>

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
                                       class="form-control">
                            </div>
                        </div>

                        <!-- frequency review -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editfrequencyReview" class="font-weight-semibold">
                                    Frequency Review <span class="text-danger"></span>
                                </label>
                                <select name="frequency_review" id="editfrequencyReview" class="form-control">
                                   <option value="">Select Frequency Review</option>
                                   <option value="6">6 Months</option>
                                   <option value="12">1 Year</option>
                                   <option value="24">2 Years</option>
                                   <option value="36">3 Years</option>
                                   <option value="48">4 Years</option>
                                   <option value="60">5 Years</option>
                                </select>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
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

@endsection

@section('scripts')
<script>
            let subMenu = "{{ $document->sub_menu }}";
            $(document).ready(function() {
                loadDocumentTypes();
                loadSubjectOptions();
                toggleFrequencyReview();
            });


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
            $('#subject').empty();

            function loadSubjectOptions() {
                const subjects = menuMapping[subMenu] || menuMapping['default'];
                subjects.forEach(subject => {
                    $('#subject').append(new Option(subject, subject));
                });
            }

            document.querySelectorAll('.view-pdf').forEach(button => {
                button.addEventListener('click', function() {
                    const documentId = this.getAttribute('data-document-id');
                    const docNumber = this.getAttribute('data-document-number');
                    const pdfFrame = document.getElementById('pdfFrame');
                    const modalTitle = document.getElementById('pdfModalLabel');

                    // Ubah judul modal
                    modalTitle.textContent = 'View Document - ' + docNumber;

                    // Set iframe src (dengan cache-buster)
                    pdfFrame.src = "{{ url('documents/view') }}/" + documentId + "?t=" + new Date()
                        .getTime();

                    // Tampilkan modal
                    const modal = new bootstrap.Modal(document.getElementById('pdfViewerModal'));
                    modal.show();
                });
            });
            // Ambil daftar document type yang sudah ada
            const usedDocumentTypes = {!! json_encode($document->documents->pluck('document_type')->toArray()) !!};
            // console.log('Used Document Types:', usedDocumentTypes);

            function loadDocumentTypes() {
                $('#documentType').html('<option value="">Select Type</option>');

                $.ajax({
                    url: `/get-document-types/${subMenu}`,
                    type: 'GET',
                    success: function(response) {
                        response.forEach(docType => {
                            // Skip jika type sudah pernah digunakan
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
                            updateDocumentNumber(); // Panggil function update
                            toggleFrequencyReview(); // Panggil function toggle
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading document types:', error);
                        loadFallbackDocumentTypes(subMenu);
                    }
                });
            }


            function updateDocumentNumber() {
                const documentNumberElement = $('#documentNumber');
                const serialNumber = $('#serial_number').val();
                const selectedDocType = $('#documentType option:selected');

                // Ambil building & department dari PHP (Blade)
                const building = "{{ strtoupper(substr($document->building, 0, 3)) }}";
                const dept =
                    "{{ strtoupper(substr($document->department, 0, 3)) }}{{ strtoupper(substr($document->dosageCode, 0, 3)) }}";

                // Jika belum pilih document type
                if (!selectedDocType.val()) {
                    documentNumberElement.val('SELECT TYPE DOC ' + serialNumber);
                    return;
                }

                // Ambil no_doc dari document type
                const noDoc = selectedDocType.data('no_doc');
                if (!noDoc) {
                    documentNumberElement.prop('readonly', false);
                    documentNumberElement.val('/' + serialNumber);
                    return;
                }

                documentNumberElement.prop('readonly', true);

                // Bentuk format nomor dokumen
                const newDocumentNumber = `${noDoc}/${building}/${dept}/${serialNumber}`;

                documentNumberElement.val(newDocumentNumber);
            }

            // Event: saat serial number berubah, perbarui document number
            $('#serial_number').on('change', function() {
                updateDocumentNumber();
            });
            // Toggle collapse/expand form
            function toggleCollapse() {
                const content = document.getElementById('formContent');
                const icon = document.getElementById('toggleIcon');

                content.classList.toggle('collapsed');
                icon.classList.toggle('collapsed');
            }

$('#documentForm').on('submit', function(e) {
    e.preventDefault(); // Mencegah submit default
    saveDocument();
});

            function saveDocument() {
                const formData = new FormData($('#documentForm')[0]);

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
                        // console.log(formData);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            confirmButtonColor: '#4f46e5'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Refresh halaman
                            }
                        });
                    },
                    error: function(xhr) {
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
            
            $(document).ready(function() {
                $('.edit-btn').on('click', function() {
                    console.log($(this).data());
                    const id = $(this).data('id');
                    const docNumber = $(this).data('doc-number');
                    const revision = $(this).data('rev');
                    const requalification = $(this).data('req');
                    const approveDate = $(this).data('approved');
                    const nextReview = $(this).data('nextreview');
                    const remark = $(this).data('remark');
                    const frequency = $(this).data('frequency');

                    // isi field di modal
                    $('#editId').val(id);
                    $('#modalDocNumber').text(docNumber);
                    $('#editDocNumber').val(docNumber);
                    $('#editRevision').val(revision);
                    $('#editRequalification').val(requalification);
                    $('#editApproveDate').val(approveDate);
                    $('#editNextReview').val(nextReview);
                    $('#editRemark').val(remark);
                    $('#editfrequencyReview').val(frequency);

                    // tampilkan modal
                    $('#editModal').modal('show');
                });
            });


            function toggleFrequencyReview() {
                const allowedTypes = ['Validation Report', 'Performance Qualification Report'];
                const selectedType = $('#documentType').val();

                if (allowedTypes.includes(selectedType) ||
                    (selectedType === 'Operational Qualification Report' && subMenu === 'computer')
                ) {
                    $('#frequencyReview').prop('disabled', false);
                } else {
                    $('#frequencyReview').prop('disabled', true).val('');
                }
            }
// Next Review Calculation auto fill
    document.addEventListener('DOMContentLoaded', function() {
        const approvedateInput = document.getElementById('approveDate');
        const reviewFrequency = document.getElementById('frequencyReview');
        const nextreviewInput = document.getElementById('nextReview');

        // Function to calculate next review date
        function calculateNextReview() {
            const approvedate = new Date(approvedateInput.value);
            const frequency = parseInt(reviewFrequency.value);

            if (!approvedate || !frequency) {
                nextreviewInput.value = '';
                return;
            }

            // Calculate next review date
            const nextReviewDate = new Date(approvedate);
            nextReviewDate.setMonth(nextReviewDate.getMonth() + frequency);

            // Format as YYYY-MM-DD for the date input
            const formattedDate = nextReviewDate.toISOString().split('T')[0];
            nextreviewInput.value = formattedDate;
        }

        // Event listeners
        approvedateInput.addEventListener('change', calculateNextReview);
        reviewFrequency.addEventListener('change', calculateNextReview);
    });
</script>

<!-- Script for custom file input label -->
<script>
    // Update custom file input label with selected filename
    $('#editUpload').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Choose file...');
    });
</script>

@endsection