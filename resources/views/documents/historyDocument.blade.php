@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-history text-primary mr-2"></i>Document History
                    </h2>
                    <p class="text-muted mb-0">View complete revision history for document: <strong>{{ $document->doc_number }}</strong></p>
                </div>
                <a href="{{ back()->getTargetUrl() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Back List Documents
                </a>
            </div>
        </div>
    </div>

    <!-- Document Information Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i>Current Document Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <p class="mb-2"><strong>Doc Number:</strong></p>
                    <p class="text-muted">{{ $document->doc_number }}</p>
                </div>
                <div class="col-md-3">
                    <p class="mb-2"><strong>Current Revision:</strong></p>
                    <p class="text-muted"><span class="badge badge-info badge-lg">Rev. {{ $document->revision_number }}</span></p>
                </div>
                <div class="col-md-3">
                    <p class="mb-2"><strong>Requalification:</strong></p>
                    <p class="text-muted"><span class="badge badge-warning badge-lg">Req. {{ $document->requalification }}</span></p>
                </div>
                <div class="col-md-3">
                    <p class="mb-2"><strong>Total Changes:</strong></p>
                    <p class="text-muted"><span class="badge badge-success badge-lg">{{ $histories->count() }} Updates</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- History Timeline -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-list-ul mr-2"></i>Update History Timeline</h5>
        </div>
        
        <div class="card-body">
            @if($histories->count() > 0)
                <div class="timeline">
                    @foreach($histories as $index => $history)
                    <div class="timeline-item">
                        <div class="timeline-marker {{ $index == 0 ? 'bg-success' : 'bg-primary' }}">
                            <i class="fas fa-{{ $index == 0 ? 'check' : 'edit' }}"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="card mb-3 {{ $index == 0 ? 'border-success' : '' }}">
                                <div class="card-header d-flex justify-content-between align-items-center {{ $index == 0 ? 'bg-success text-white' : 'bg-light' }}">
                                    <div>
                                        <h6 class="mb-0">
                                            @if($index == 0)
                                                <span class="badge badge-light text-success mr-2">LATEST</span>
                                            @endif
                                            Revision {{ $history->revision_number }} - Requalification {{ $history->requalification }}
                                        </h6>
                                        <small class="{{ $index == 0 ? 'text-white-50' : 'text-muted' }}">
                                            <i class="fas fa-clock mr-1"></i>{{ \Carbon\Carbon::parse(substr($history->getOriginal('created_at'), 0, 19))->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                    <div>
                                        @if($history->file_path)
                                            <a href="{{ asset('storage/' . $history->file_path) }}" 
                                               class="btn btn-sm {{ $index == 0 ? 'btn-light' : 'btn-primary' }}" 
                                               target="_blank">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </a>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-primary" data-document-id="{{ $history->id }}" data-document-number="{{ $history->doc_number }}" onclick="viewPdf(this)">
                                            <i class="fas fa-eye mr-1"></i>View PDF
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong><i class="fas fa-calendar-check text-success mr-2"></i>Approve Date:</strong></p>
                                            <p class="text-muted">{{ $history->approved_date ? \Carbon\Carbon::parse($history->approved_date)->format('d M Y') : '-' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong><i class="fas fa-calendar-alt text-warning mr-2"></i>Next Review:</strong></p>
                                            <p class="text-muted">{{ $history->next_review ? \Carbon\Carbon::parse($history->next_review)->format('d M Y') : '-' }}</p>
                                        </div>
                                    </div>

                                    @if($history->remarks)
                                    <div class="mt-3 p-3 bg-light rounded">
                                        <p class="mb-1"><strong><i class="fas fa-comment-alt text-info mr-2"></i>Remark:</strong></p>
                                        <p class="mb-0 text-muted">{{ $history->remarks }}</p>
                                    </div>
                                    @endif

                                    <div class="mt-3 pt-3 border-top">
                                        <small class="text-muted">
                                            <i class="fas fa-user mr-1"></i>Updated by: <strong>{{ $history->created_by }}</strong>
                                            @if($history->getOriginal('updated_at'))
                                                <span class="ml-3"><i class="fas fa-clock mr-1"></i>{{ \Carbon\Carbon::parse(substr($history->getOriginal('updated_at'), 0, 19))->diffForHumans() }}</span>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No History Found</h5>
                    <p class="text-muted">This document doesn't have any update history yet.</p>
                </div>
            @endif
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
<!-- Custom CSS -->
<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 30px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e0e0e0;
    }

    .timeline-item {
        position: relative;
        padding-left: 80px;
        margin-bottom: 30px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-marker {
        position: absolute;
        left: 15px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 0 0 4px #fff, 0 0 0 6px #e0e0e0;
        z-index: 1;
    }

    .timeline-content {
        position: relative;
    }

    .badge-lg {
        font-size: 0.95rem;
        padding: 0.4rem 0.8rem;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .bg-success.text-white .btn-light {
        color: #28a745 !important;
    }
</style>
@endsection

@section('scripts')
    <script>
      function viewPdf(button) {
    const documentId = button.getAttribute('data-document-id');
    const docNumber = button.getAttribute('data-document-number');
    const pdfFrame = document.getElementById('pdfFrame');
    const modalTitle = document.getElementById('pdfModalLabel');

    // Ubah judul modal
    modalTitle.textContent = 'View Document - ' + docNumber;

    // Set iframe src (dengan cache-buster)
    pdfFrame.src = "{{ url('documents/history/view') }}/" + documentId + "?t=" + new Date().getTime();

    // Tampilkan modal
    const modal = new bootstrap.Modal(document.getElementById('pdfViewerModal'));
    modal.show();
}  
    </script>
@endsection