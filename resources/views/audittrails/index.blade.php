@extends('layouts.layout')

@section('content')
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Trail</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col">
                <h2><i class="fas fa-history me-2"></i>Audit Trail</h2>
                <p class="text-muted">Log aktivitas perubahan data sistem</p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <form method="GET" class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-select" name="action">
                            <option value="">-- All Action --</option>
                            <option value="CREATED" {{ request('action')=='CREATED' ? 'selected' : '' }}>Created
                            </option>
                            <option value="UPDATED" {{ request('action')=='UPDATED' ? 'selected' : '' }}>Updated
                            </option>
                            <option value="DELETED" {{ request('action')=='DELETED' ? 'selected' : '' }}>Deleted
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari di old/new values..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                                <div class="d-flex" style="gap: 0.5rem;">
                                    <button type="submit" class="btn btn-primary flex-fill">
                                        Filter
                                    </button>
                                    <a href="{{ route('audit-trail.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-redo"></i>
                                    </a>
                                </div>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="40"></th>
                                <th>User</th>
                                <th>Table Name</th>
                                <th>Record ID</th>
                                <th>Action</th>
                                <th>Created At</th>
                                <th width="80">Detail</th>
                            </tr>
                        </thead>
                        <tbody id="auditTableBody">
                            @forelse ($auditTrails as $item)
                            <tr class="align-middle">
                                <td>
                                    <button class="btn btn-sm btn-link text-secondary p-0" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $item->id }}"
                                        aria-expanded="false" aria-controls="collapse{{ $item->id }}">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </td>
                                <td>{{ $item->user_name }}</td>
                                <td><code>{{ $item->table_name }}</code></td>
                                <td><span class="badge bg-secondary">{{ $item->record_id }}</span></td>
                                <td>
                                    <span class="badge 
                            @if($item->action == 'CREATED') bg-success 
                            @elseif($item->action == 'UPDATED') bg-warning 
                            @else bg-danger @endif">
                                        {{ $item->action }}
                                    </span>
                                </td>
                                <td><small>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</small>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $item->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="collapse" id="collapse{{ $item->id }}">
                                <td colspan="7" class="p-4 bg-light">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-danger">
                                                <i class="fas fa-database me-2"></i>Old Values
                                            </h6>
                                            <div class="card">
                                                <div class="card-body">
                                                    @if($item->old_values && (is_array($item->old_values) ?
                                                    count($item->old_values) > 0 : $item->old_values != '[]'))
                                                    @php
                                                    $oldValues = is_array($item->old_values) ? $item->old_values :
                                                    json_decode($item->old_values, true);
                                                    @endphp
                                                    <pre class="mb-0">
                                                        <code>
                                                            {{ json_encode($oldValues, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}
                                                        </code>
                                                    </pre>
                                                    @else
                                                    <p class="text-muted mb-0">No previous data</p>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-success">
                                                <i class="fas fa-database me-2"></i>New Values
                                            </h6>
                                            <div class="card">
                                                <div class="card-body">
                                                    @if($item->new_values && (is_array($item->new_values) ?
                                                    count($item->new_values) > 0 : $item->new_values != '[]'))
                                                    @php
                                                    $newValues = is_array($item->new_values) ? $item->new_values :
                                                    json_decode($item->new_values, true);
                                                    @endphp
                                                    <pre class="mb-0">
                                                        <code>
                                                            {{ json_encode($newValues, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}
                                                        </code>
                                                    </pre>
                                                    @else
                                                    <p class="text-muted mb-0">Data deleted</p>
                                                    @endif
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No audit data found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Total Records: {{ $auditTrails->total() }}</small>
                <div>
                    {{ $auditTrails->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
@endsection