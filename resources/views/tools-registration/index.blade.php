@extends('layouts.layout')

@section('title', 'Tools Registration')

@push('styles')
<style>
    .submenu-selector {
        font-size: 1.1rem;
        padding: 0.75rem;
    }

    .card-menu {
        border-radius: 0.5rem;
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
        padding: 1.5rem;
        text-align: center;
        background: white;
    }

    .card-menu:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        text-decoration: none;
        color: inherit;
    }

    .card-menu .icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .card-menu .title {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .card-menu .category {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .category-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.75rem;
    }

    .badge-qualification {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .badge-validation {
        background-color: #f3e8ff;
        color: #6b21a8;
    }

    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .stats-card .number {
        font-size: 2.5rem;
        font-weight: bold;
    }

    .stats-card .label {
        font-size: 0.9rem;
        opacity: 0.9;
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
                    <h1 class="mb-2 font-weight-bold">
                        <i class="fas fa-tools text-primary mr-2"></i>
                        TOOLS REGISTRATION
                    </h1>
                    <p class="text-muted mb-0">Manage tools registration, qualification, and validation</p>
                </div>
            </div>

            <!-- Quick Navigation - Moved to Sidebar -->
            <!-- The dropdown menu is now available in the sidebar under Tools/Product Registration -->

            <!-- Qualification Section -->
            <div class="mb-5">
                <h3 class="mb-4 font-weight-bold">
                    <i class="fas fa-check-circle text-primary mr-2"></i>
                    QUALIFICATION (3 Sub-Menus)
                </h3>
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4">
                        <a href="{{ route('tools.show', 'equipment') }}" class="card-menu">
                            <div class="icon">⚙️</div>
                            <div class="title">Equipment Qualification</div>
                            <div class="category">Register & track equipment</div>
                            <span class="category-badge badge-qualification">Qualification</span>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-4">
                        <a href="{{ route('tools.show', 'utility') }}" class="card-menu">
                            <div class="icon">⚡</div>
                            <div class="title">Utility Qualification</div>
                            <div class="category">Manage utility systems</div>
                            <span class="category-badge badge-qualification">Qualification</span>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-4">
                        <a href="{{ route('tools.show', 'room') }}" class="card-menu">
                            <div class="icon">🏢</div>
                            <div class="title">Room Qualification</div>
                            <div class="category">Monitor room conditions</div>
                            <span class="category-badge badge-qualification">Qualification</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Validation Section -->
            <div>
                <h3 class="mb-4 font-weight-bold">
                    <i class="fas fa-flask text-danger mr-2"></i>
                    VALIDATION (4 Sub-Menus)
                </h3>
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4">
                        <a href="{{ route('tools.show', 'computer') }}" class="card-menu">
                            <div class="icon">💻</div>
                            <div class="title">Computerize System</div>
                            <div class="category">System validation & testing</div>
                            <span class="category-badge badge-validation">Validation</span>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-4">
                        <a href="{{ route('tools.show', 'process-mediafill') }}" class="card-menu">
                            <div class="icon">🧪</div>
                            <div class="title">Process & Mediafill</div>
                            <div class="category">Process & Mediafill validation</div>
                            <span class="category-badge badge-validation">Validation</span>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-4">
                        <a href="{{ route('tools.show', 'cleaning') }}" class="card-menu">
                            <div class="icon">🧹</div>
                            <div class="title">Cleaning</div>
                            <div class="category">Cleaning validation</div>
                            <span class="category-badge badge-validation">Validation</span>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-4">
                        <a href="{{ route('tools.show', 'analytical-method') }}" class="card-menu">
                            <div class="icon">📊</div>
                            <div class="title">Analytical Method</div>
                            <div class="category">Analytical Method Cleaning Validation</div>
                            <span class="category-badge badge-validation">Validation</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="alert alert-info mt-5" role="alert">
                <h5 class="alert-heading">
                    <i class="fas fa-info-circle mr-2"></i>
                    Information
                </h5>
                <ul class="mb-0">
                    <li>Each sub-menu has its own dedicated page with form and data table</li>
                    <li>You can add, view, and manage data for each category separately</li>
                    <li>Use the dropdown menu above for quick navigation</li>
                    <li>All data is automatically saved and can be edited anytime</li>
                </ul>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function navigateToSubMenu(subMenu) {
    if (subMenu) {
        window.location.href = `/tools-registration/${subMenu}`;
    }
}
</script>
@endpush