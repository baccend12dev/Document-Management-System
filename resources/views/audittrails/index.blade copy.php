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
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari user, tabel, atau record...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="filterAction">
                            <option value="">Semua Action</option>
                            <option value="INSERT">INSERT</option>
                            <option value="UPDATE">UPDATE</option>
                            <option value="DELETE">DELETE</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="filterDate">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-secondary w-100" onclick="resetFilters()">
                            <i class="fas fa-redo me-1"></i>Reset
                        </button>
                    </div>
                </div>
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
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Menampilkan <span id="rowCount">0</span> data</small>
                    <nav>
                        <ul class="pagination pagination-sm mb-0" id="pagination">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sample data audit trail
       const auditData = {!! json_encode($auditTrails, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!};
    console.log(auditData);
        let filteredData = [...auditData];
        let expandedRows = new Set();

        function getActionBadge(action) {
            const badges = {
                'INSERT': 'success',
                'UPDATE': 'warning',
                'DELETE': 'danger'
            };
            return `<span class="badge bg-${badges[action]}">${action}</span>`;
        }

        function renderTable() {
            const tbody = document.getElementById('auditTableBody');
            tbody.innerHTML = '';

            filteredData.forEach((item, index) => {

                const isExpanded = expandedRows.has(item.id);
                
                // Main row
                const mainRow = `
                    <tr class="align-middle">
                        <td>
                            <button class="btn btn-sm btn-link text-secondary p-0" onclick="toggleRow(${item.id})">
                                <i class="fas fa-chevron-${isExpanded ? 'down' : 'right'}"></i>
                            </button>
                        </td>
                        <td>${item.user_email}</td>
                        <td><code>${item.table_name}</code></td>
                        <td><span class="badge bg-secondary">${item.record_id}</span></td>
                        <td>${getActionBadge(item.action)}</td>
                        <td><small>${item.created_at}</small></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="toggleRow(${item.id})">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                `;
                
                tbody.innerHTML += mainRow;

                // Detail row
                if (isExpanded) {
                    const detailRow = `
                        <tr class="bg-light">
                            <td colspan="7" class="p-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-danger"><i class="fas fa-database me-2"></i>Old Value</h6>
                                        <div class="card">
                                            <div class="card-body">
                                                ${item.old_values ? 
                                                    `<pre class="mb-0"><code>${JSON.stringify(item.old_values, null, 2)}</code></pre>` : 
                                                    '<p class="text-muted mb-0">No previous data</p>'}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-success"><i class="fas fa-database me-2"></i>New Value</h6>
                                        <div class="card">
                                            <div class="card-body">
                                                ${item.new_values ? 
                                                    `<pre class="mb-0"><code>${JSON.stringify(item.new_values, null, 2)}</code></pre>` : 
                                                    '<p class="text-muted mb-0">Data deleted</p>'}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += detailRow;
                }
            });

            document.getElementById('rowCount').textContent = filteredData.length;
        }

        function toggleRow(id) {
            if (expandedRows.has(id)) {
                expandedRows.delete(id);
            } else {
                expandedRows.add(id);
            }
            renderTable();
        }

        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const actionFilter = document.getElementById('filterAction').value;
            const dateFilter = document.getElementById('filterDate').value;

            filteredData = auditData.filter(item => {
                const matchSearch = !searchTerm || 
                    item.user.toLowerCase().includes(searchTerm) ||
                    item.table_name.toLowerCase().includes(searchTerm) ||
                    item.record_id.toLowerCase().includes(searchTerm);

                const matchAction = !actionFilter || item.action === actionFilter;
                
                const matchDate = !dateFilter || item.created_at.startsWith(dateFilter);

                return matchSearch && matchAction && matchDate;
            });

            renderTable();
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('filterAction').value = '';
            document.getElementById('filterDate').value = '';
            filteredData = [...auditData];
            renderTable();
        }

        // Event listeners
        document.getElementById('searchInput').addEventListener('input', applyFilters);
        document.getElementById('filterAction').addEventListener('change', applyFilters);
        document.getElementById('filterDate').addEventListener('change', applyFilters);

        // Initial render
        renderTable();
    </script>
</body>
</html>
@endsection