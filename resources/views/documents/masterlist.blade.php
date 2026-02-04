@extends('layouts.layout')


@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center">
                <div class="bg-blue-600 text-white p-2 rounded-lg mr-3">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Document Management System</h1>
            </div>
        </div>
    </header>
    <!-- Dashboard Stats -->
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Filters -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <form method="GET" action="{{ route('masterlist-documents.index') }}"
                class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sub-Menu</label>
                    <select name="submenu" onchange="this.form.submit()"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Sub Menu</option>
                        @foreach($submenuOptions as $option)
                        <option value="{{ $option }}" {{ request('submenu') == $option ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <select name="department" onchange="this.form.submit()"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Department</option>
                        <option value="PR" {{ request('department') == 'PR' ? 'selected' : '' }}>PR Production</option>
                        <option value="QA" {{ request('department') == 'QA' ? 'selected' : '' }}>QA Qaulity Assurance
                        </option>
                        <option value="QC" {{ request('department') == 'QC' ? 'selected' : '' }}>QC</option>
                        <option value="TM" {{ request('department') == 'TM' ? 'selected' : '' }}>TM</option>
                        <option value="IT" {{ request('department') == 'IT' ? 'selected' : '' }}>IT</option>
                        <option value="LG" {{ request('department') == 'LG' ? 'selected' : '' }}>LG</option>
                        <option value="RD" {{ request('department') == 'RD' ? 'selected' : '' }}>RD</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dosage Code</label>
                    <select name="dosage_code" onchange="this.form.submit()"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Dosage</option>
                        <option value="INA" {{ request('dosage_code') == 'INA' ? 'selected' : '' }}>INA</option>
                        <option value="INV" {{ request('dosage_code') == 'INV' ? 'selected' : '' }}>INV</option>
                        <option value="KPS" {{ request('dosage_code') == 'KPS' ? 'selected' : '' }}>KPS</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search Tool</label>
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search tools, Equipment Name..."
                            value="{{ request('search') }}"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 pl-10 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">

                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                <div class="d-flex" style="gap: 0.5rem;">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('masterlist-documents.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>

            </form>
        </div>

        <!-- Tools Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($tools as $tool)
            <div class="bg-white shadow rounded-lg p-4 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                     @php
                     $categoryConfig = [
                    'equipment' => ['icon' => 'wrench', 'class' => 'info', 'label' => 'Equipment'],
                    'utility' => ['icon' => 'bolt', 'class' => 'warning', 'label' => 'Utility'],
                    'room' => ['icon' => 'building', 'class' => 'success', 'label' => 'Room'],
                    'computer' => ['icon' => 'laptop', 'class' => 'primary', 'label' => 'Computer'],
                    'cleaning' => ['icon' => 'spray-can', 'class' => 'secondary', 'label' => 'Cleaning'],
                    'process-mediafill' => ['icon' => 'flask', 'class' => 'warning', 'label' => 'Process '],
                    'analytical-method' => ['icon' => 'chart-line', 'class' => 'info', 'label' => 'Analytical '],
                    ];
                    $config = isset($categoryConfig[$tool->sub_menu]) ? $categoryConfig[$tool->sub_menu] : ['icon' => 'tag', 'class' => 'secondary', 'label' => ucfirst($tool->sub_menu)];
                    @endphp
                    <div>
                        <div class="flex items-center">
                            <div class="badge badge-{{ $config['class'] }} p-2 rounded-lg mr-3">
                                <i class="fas fa-{{ $config['icon'] }}"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900">{{ $tool->equipment_id }} {{ $tool->product_code }}
                            </h3>
                        </div>
                        <p class="text-sm text-gray-600">{{ $tool->equipment_name }}</p>
                        <p class="text-xs text-gray-500">{{ $tool->building }} | {{ $tool->department }}
                            {{ $tool->dosageCode }}</p>
                    </div>
                    <span
                        class="text-xs px-2 py-1 rounded-full font-bold {{ $tool->sub_menu === 'equipment' ? 'bg-green-100 text-green-800' : ($tool->sub_menu === 'computer' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ $config['label'] }}
                    </span>
                </div>
                <div class="mt-3">
                    <p class="text-xs text-gray-500 mb-2">
                        Status: {{ $tool->documents->count() }} docs
                    </p>
                    <p class="text-xs text-gray-500">Updated: {{ $tool->updated_at }}</p>
                </div>
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('detail-document.detail', $tool->id) }}"
                        class="flex-1 bg-blue-600 text-white text-xs py-2 rounded-md hover:bg-blue-700 transition text-center">
                        View Details
                    </a>
                    <a href="#"
                        class="flex-1 bg-gray-200 text-gray-800 text-xs py-2 rounded-md hover:bg-gray-300 transition text-center">
                        Add Doc
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">No tools found</h3>
                <p class="text-gray-500">Try adjusting your search or filter criteria</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8 bg-white shadow rounded-lg p-4">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="text-sm text-gray-700 mb-4 md:mb-0">
                    Showing <span class="font-medium">{{ $tools->firstItem() }}</span> to
                    <span class="font-medium">{{ $tools->lastItem() }}</span> of
                    <span class="font-medium">{{ $tools->total() }}</span> entries
                </div>
                <form method="GET" action="{{ url()->current() }}" class="flex items-center space-x-2">
                    <select
                        name="per_page"
                        onchange="this.form.submit()"
                        class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per page</option>
                        <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>20 per page</option>
                        <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50 per page</option>
                        <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100 per page</option>
                    </select>
                    {{ $tools->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                </form>
            </div>
        </div>
    </div>
</body>

</html>
@endsection