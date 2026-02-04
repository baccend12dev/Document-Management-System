@extends('layouts.layout')
@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-4">
        <!-- Header -->
        <!-- Alert Success -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filter & Add Button -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-end">
                    <div class="col-md-8">
                        <form method="GET" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Cari User</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Nama atau email..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-1"></i>Filter
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="#tambah-user" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i>Tambah User
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>UserName</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <strong>{{ $user->username }}</strong>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role ?: '-' }}</td>
                                    <!-- <td>
                                        <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ $user->status == 'active' ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td> -->
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button onclick="toggleStatus({{ $user->id }}, '{{ $user->status }}')" 
                                                    class="btn btn-{{ $user->status == 'active' ? 'warning' : 'success' }}"
                                                    title="{{ $user->status == 'active' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-{{ $user->status == 'active' ? 'eye-slash' : 'eye' }}"></i>
                                            </button>
                                            <form method="POST" action="{{ route('users.destroy', $user) }}" 
                                                  style="display: inline-block;" 
                                                  onsubmit="return confirm('Yakin hapus user ini?')">
                                               {{csrf_field()}}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                        <p class="mb-0">Tidak ada data user</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $users->appends(request()->query())->links() }}
            </div>
        @endif

        <div class="card" id="tambah-user">
                <div class="card-header">
                    <h5 class="mb-0">Tambah User Baru</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}">
                       {{csrf_field() }}
                        <!-- Input Email -->
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Alamat Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"  required autocomplete="email">
                            </div>
                        </div>
                        <!-- Input Username -->
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" required autocomplete="username">
                            </div>
                        </div>
                        <!-- Input Password -->
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                            </div>
                        </div>
                        <!-- Dropdown Role -->
                        <div class="form-group row">
                            <label for="role_id" class="col-md-4 col-form-label text-md-right">Role</label>

                            <div class="col-md-6">
                                <select id="role_id" class="form-control" name="role" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="supervisor">Supervisor</option>
                                    <option value="technician">Technician</option>
                                    <option value="admin">Admin</option>
                                    <option value="guest">Viewer</option>
                                </select>
                            </div>
                        </div>
                        <!-- Tombol Submit -->
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Simpan User
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Setup CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        async function toggleStatus(userId, currentStatus) {
            const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
            
            try {
                const response = await fetch(`/users/${userId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ status: newStatus })
                });
                
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Gagal mengubah status user');
                }
            } catch (error) {
                alert('Terjadi kesalahan: ' + error.message);
            }
        }
    </script>
</body>
</html>
@endsection