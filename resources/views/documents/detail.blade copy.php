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
}

.detail-label {
    font-weight: 600;
    color: #555;
    font-size: 13px;
    text-transform: uppercase;
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
    $isComplete = $totalDocs >= $totalTypes;
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
                        <span class="detail-label">Sub-Menu</span>
                        <span class="detail-value">{{$document->sub_menu}}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status</span>
                        @if ($isComplete)
                            <span class="status-badge bg-success text-white">Complete</span>
                        @else
                            <span class="status-badge bg-warning text-dark">In Progress</span>
                        @endif
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
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon primary view-pdf" data-document-id="{{ $doc->id }}"
                                            data-document-number="{{ $doc->doc_number }}">
                                            <span>👁️ view</span>
                                        </button>
                                        <a href="{{ route('documents.download', $doc->id) }}?t={{ time() }}"
                                            class="btn-icon" title="Download">
                                            <span>⬇️</span>
                                        </a>
                                        <button class="btn-icon edit-btn" title="Edit" data-id="{{ $doc->id }}"
                                            data-doc-number="{{ $doc->doc_number }}"
                                            data-rev="{{ $doc->revision_number }}"
                                            data-approved="{{ $doc->approved_date }}"
                                            data-req="{{ $doc->requalification }}" data-building="{{ $doc->subject }}"
                                            data-nextreview="{{ $doc->next_review }}">
                                            ✏️
                                        </button>
                                        <button class="btn-icon" title="History">📋</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Add New Document Section -->
            <div class="section">
                <div class="collapse-header" onclick="toggleCollapse()">
                    <h2 class="section-title" style="border: none; margin: 0; padding: 0;">Add New Document</h2>
                    <span class="toggle-icon" id="toggleIcon">▼</span>
                </div>

                <div class="collapsible-content" id="formContent">
                    <form id="documentForm">
                        <input type="hidden" name="tools_id" value="{{ $document->id }}">
                        <input type="hidden" name="sub_menu" value="{{ $document->sub_menu }}">
                        <div class="form-grid">
                            <!-- Document Type -->
                            <div class="form-group">
                                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                                    <div style="display: flex; flex-direction: column;">
                                        <label>Document Type <span class="required">*</span></label>
                                        <select id="documentType" name="document_type" required>
                                            <option value="">Select Type</option>
                                        </select>
                                    </div>
                                    <div style="display: flex; flex-direction: column;">
                                        <label>Serial Number <span class="required">*</span></label>
                                        <select id="serial_number" name="serial_number" required>
                                            @for ($i = 0; $i <= 100; $i++) <option value="{{ sprintf('%03d', $i) }}">
                                                {{ sprintf('%03d', $i) }}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Document Number (Auto-generated) -->
                            <div class="form-group">
                                <label>Document Number</label>
                                <input type="text" class="form-control" style="font-weight: bold;" id="documentNumber"
                                    name="document_number" readonly>
                            </div>
                            <!-- Revision Number -->
                            <div class="form-group">
                                <label>Revision Number</label>
                                <select class="form-control" name="revision_number" id="revisionNumber" required>
                                    <option value="">Select Revision</option>
                                    @for ($i = 0; $i <= 100; $i++) <option value="{{ sprintf('%02d', $i) }}">
                                        {{ sprintf('%02d', $i) }}</option>
                                        @endfor
                                </select>
                            </div>

                            <!-- Requalification -->
                            <div class="form-group">
                                <label>Requalification</label>
                                <select class="form-control" name="requalification" id="requalification" required>
                                    <option value="">Select Requalification</option>
                                    @for ($i = 0; $i <= 100; $i++) <option value="{{ sprintf('%02d', $i) }}">
                                        {{ sprintf('%02d', $i) }}</option>
                                        @endfor
                                </select>
                            </div>

                            <!-- Model & Type -->
                            <div class="form-group">
                                <label>Model & Type <span class="required"></span></label>
                                <input type="text" id="modelType" name="modelType" placeholder="Enter Model & Type">
                            </div>

                            <!-- Subject -->
                            <div class="form-group">
                                <label>Subject</label>
                                <select class="form-control" name="subject" id="subject" name="subject" required>
                                    <option value="">Select Subject</option>
                                    <option value="Equipment">Equipment</option>
                                    <option value="System">System</option>
                                    <option value="Product">Product</option>
                                    <option value="PW">PW</option>
                                    <option value="WFI">WFI</option>
                                    <option value="COAF">CAOF</option>
                                    <option value="N2">N2</option>
                                    <option value="Checklist">Checklist</option>
                                    <option value="Report">Report</option>
                                </select>
                            </div>
                            <!-- Approve Date -->
                            <div class="form-group">
                                <label>Approve Date</label>
                                <input type="date" id="approveDate" name="approvedate">
                            </div>

                            <!-- Frequency Review -->
                            <div class="form-group">
                                <label>Frequency Review</label>
                                <select id="frequencyReview" name="review_frequency">
                                    <option value="">Select Frequency</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">1 Year</option>
                                    <option value="24">2 Years</option>
                                    <option value="36">3 Years</option>
                                    <option value="48">4 Years</option>
                                    <option value="60">5 Years</option>
                                </select>
                            </div>

                            <!-- Next Review -->
                            <div class="form-group">
                                <label>Next Review</label>
                                <input type="date" id="nextReview" name="nextreview">
                            </div>
                            <div class="form-group">
                                <label>Upload Document <span class="required">*</span></label>
                                <input type="file" id="fileInput" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Remarks <span class="required"></span></label>
                                <input type="text" id="remarks" name="remarks" placeholder="Enter Remarks">
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                            <button type="submit" class="btn btn-primary" id="saveBtn" onclick="saveDocument()">💾 Save
                                Document</button>
                        </div>
                    </form>
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

        <!-- Modal Edit Document -->
        <!-- Edit Modal -->
        <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Edit Document - <span id="modalDocNumber"></span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form id="editForm" action="{{ route('document.update') }}" method="POST"
                            enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="id" id="editId">

                            <div class="form-group">
                                <label>Doc Number</label>
                                <input type="text" name="doc_number" id="editDocNumber" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Revision</label>
                                <select class="form-control" name="editrevision_number" id="editRevision" required>
                                    <option value="">Select Revision</option>
                                    @for ($i = 0; $i <= 100; $i++) <option value="{{ sprintf('%02d', $i) }}">
                                        {{ sprintf('%02d', $i) }}</option>
                                        @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Requalification</label>
                                <select class="form-control" name="editrequalification" id="editRequalification"
                                    required>
                                    <option value="">Select Requalification</option>
                                    @for ($i = 0; $i <= 100; $i++) <option value="{{ sprintf('%02d', $i) }}">
                                        {{ sprintf('%02d', $i) }}</option>
                                        @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Approve Date</label>
                                <input type="date" name="approve_date" id="editApproveDate" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Next Review</label>
                                <input type="date" name="next_review" id="editNextReview" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Upload Document</label>
                                <input type="file" name="file" id="editUpload" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
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
        });

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
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonColor: '#4f46e5'
                    }).then(() => {
                        closeModal();
                        location.reload();
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
                const id = $(this).data('id');
                const docNumber = $(this).data('doc-number');
                const revision = $(this).data('rev');
                const requalification = $(this).data('req');
                const approveDate = $(this).data('approved');
                const nextReview = $(this).data('nextreview');

                // isi field di modal
                $('#editId').val(id);
                $('#modalDocNumber').text(docNumber);
                $('#editDocNumber').val(docNumber);
                $('#editRevision').val(revision);
                $('#editRequalification').val(requalification);
                $('#editApproveDate').val(approveDate);
                $('#editNextReview').val(nextReview);

                // tampilkan modal
                $('#editModal').modal('show');
            });
        });
        </script>

        @endsection