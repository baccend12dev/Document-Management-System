@extends('layouts.layout')

@section('title', 'Tools Registration')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/tools-registration.css') }}">
<style>
    .main-category-tab {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .main-category-tab.active {
        background: #4f46e5 !important;
        color: white !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .main-category-tab:not(.active) {
        background: white !important;
        color: #374151 !important;
    }
    .sub-menu-tab {
        cursor: pointer;
        transition: all 0.3s ease;
        border-right: 1px solid #e5e7eb;
    }
    .sub-menu-tab:last-child {
        border-right: none;
    }
    .sub-menu-tab.active {
        background: #4f46e5 !important;
        color: white !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .sub-menu-tab:not(.active) {
        background: #f9fafb !important;
        color: #374151 !important;
    }
    .sub-menu-tab:hover:not(.active) {
        background: #f3f4f6 !important;
    }
    .form-section {
        display: none;
    }
    .form-section.active {
        display: block;
        animation: fadeIn 0.3s;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            <!-- Header -->
            <div class="card shadow-lg" style="border-radius: 1.5rem 1.5rem 0 0; border-bottom: 4px solid #4f46e5;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="mb-2 font-weight-bold">
                                <i class="fas fa-tools text-primary mr-2"></i>
                                TOOLS REGISTRATION SYSTEM
                            </h1>
                            <p class="text-muted mb-0">Comprehensive Qualification & Validation Management</p>
                        </div>
                        <div class="text-right">
                            <small class="text-muted d-block">Current Module</small>
                            <h4 class="mb-0 font-weight-bold text-primary text-capitalize" id="current-category">Qualification</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Category Tabs -->
            <div class="d-flex shadow-lg">
                <div class="main-category-tab active flex-fill text-center py-3 px-3" 
                     data-category="qualification" 
                     style="font-weight: bold; font-size: 1.1rem;">
                    <i class="fas fa-tools mr-2"></i>
                    QUALIFICATION
                </div>
                <div class="main-category-tab flex-fill text-center py-3 px-3" 
                     data-category="validation" 
                     style="font-weight: bold; font-size: 1.1rem;">
                    <i class="fas fa-clipboard-check mr-2"></i>
                    VALIDATION
                </div>
            </div>

            <!-- Sub Menu Tabs - Qualification -->
            <div class="card shadow-lg mb-0" style="border-radius: 0; border-bottom: 2px solid #e5e7eb;" id="qualification-submenu">
                <div class="card-body p-0">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <div class="sub-menu-tab active text-center py-4 px-3" data-submenu="equipment" data-category="qualification">
                                <i class="fas fa-wrench fa-2x mb-2"></i>
                                <div class="font-weight-semibold">Equipment Qualification</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sub-menu-tab text-center py-4 px-3" data-submenu="utility" data-category="qualification">
                                <i class="fas fa-bolt fa-2x mb-2"></i>
                                <div class="font-weight-semibold">Utility Qualification</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sub-menu-tab text-center py-4 px-3" data-submenu="room" data-category="qualification">
                                <i class="fas fa-building fa-2x mb-2"></i>
                                <div class="font-weight-semibold">Room Qualification</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub Menu Tabs - Validation -->
            <div class="card shadow-lg mb-0" style="border-radius: 0; border-bottom: 2px solid #e5e7eb; display: none;" id="validation-submenu">
                <div class="card-body p-0">
                    <div class="row no-gutters">
                        <div class="col-md-2">
                            <div class="sub-menu-tab text-center py-4 px-2" data-submenu="computer" data-category="validation">
                                <i class="fas fa-laptop fa-2x mb-2"></i>
                                <div class="font-weight-semibold small">Computerize System</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="sub-menu-tab text-center py-4 px-2" data-submenu="process-system" data-category="validation">
                                <i class="fas fa-cogs fa-2x mb-2"></i>
                                <div class="font-weight-semibold small">Process System</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="sub-menu-tab text-center py-4 px-2" data-submenu="process-mediafill" data-category="validation">
                                <i class="fas fa-flask fa-2x mb-2"></i>
                                <div class="font-weight-semibold small">Process & Mediafill</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="sub-menu-tab text-center py-4 px-2" data-submenu="cleaning" data-category="validation">
                                <i class="fas fa-spray-can fa-2x mb-2"></i>
                                <div class="font-weight-semibold small">Cleaning</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="sub-menu-tab text-center py-4 px-2" data-submenu="analytical-validation" data-category="validation">
                                <i class="fas fa-vial fa-2x mb-2"></i>
                                <div class="font-weight-semibold small">Analytical Validation</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="sub-menu-tab text-center py-4 px-2" data-submenu="analytical-method" data-category="validation">
                                <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                                <div class="font-weight-semibold small">Analytical Method</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="card shadow-lg" style="border-radius: 0 0 1.5rem 1.5rem;">
                <div class="card-body p-5">
                    
                    <!-- Forms Container -->
                    <div id="forms-container">
                        @include('tools-registration.partials.equipment-form')
                        @include('tools-registration.partials.utility-form')
                        @include('tools-registration.partials.room-form')
                        @include('tools-registration.partials.computer-system-form')
                        @include('tools-registration.partials.process-system-form')
                        @include('tools-registration.partials.process-mediafill-form')
                        @include('tools-registration.partials.cleaning-form')
                        @include('tools-registration.partials.analytical-validation-form')
                        @include('tools-registration.partials.analytical-method-form')
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/tools-registration.js') }}"></script>
<script>
$(document).ready(function() {
    // Initialize
    let currentCategory = 'qualification';
    let currentSubMenu = 'equipment';

    // Main Category Tab Click
    $('.main-category-tab').click(function() {
        const category = $(this).data('category');
        
        // Update active state
        $('.main-category-tab').removeClass('active');
        $(this).addClass('active');

        // Update current category text
        $('#current-category').text(category.charAt(0).toUpperCase() + category.slice(1));

        // Show/hide submenu
        if (category === 'qualification') {
            $('#qualification-submenu').show();
            $('#validation-submenu').hide();
            currentSubMenu = 'equipment';
        } else {
            $('#qualification-submenu').hide();
            $('#validation-submenu').show();
            currentSubMenu = 'computer';
        }

        currentCategory = category;

        // Reset submenu and show first form
        $(`.sub-menu-tab[data-category="${category}"]`).removeClass('active');
        $(`.sub-menu-tab[data-category="${category}"]`).first().addClass('active');

        $('.form-section').removeClass('active');
        $(`#form-${currentSubMenu}`).addClass('active');
    });

    // Sub Menu Tab Click
    $('.sub-menu-tab').click(function() {
        const submenu = $(this).data('submenu');
        const category = $(this).data('category');

        // Update active state
        $(`.sub-menu-tab[data-category="${category}"]`).removeClass('active');
        $(this).addClass('active');

        // Show corresponding form
        $('.form-section').removeClass('active');
        $(`#form-${submenu}`).addClass('active');

        currentSubMenu = submenu;
    });

    // Form Submit
    $('.submit-form').click(function() {
        const formId = $(this).data('form');
        const formData = $(`#${formId}`).serialize();

        $.ajax({
            url: '{{ route("tools.registration.store") }}',
            method: 'POST',
            data: formData + '&category=' + currentCategory + '&sub_menu=' + currentSubMenu,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    confirmButtonColor: '#4f46e5'
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    });

    // Reset Form
    $('.reset-form').click(function() {
        const formId = $(this).data('form');
        $(`#${formId}`)[0].reset();
    });
});
</script>
@endpush