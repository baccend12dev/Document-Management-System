@extends('layouts.layout')
@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-4">
        <!-- Header -->
        <div class="card mb-4">
            <div class="card-body">
                <h1 class="card-title mb-2">
                    <i class="fas fa-user-plus me-2"></i>Tambah User Baru
                </h1>
                <p class="card-text text-muted">Isi form di bawah untuk menambahkan user baru</p>
            </div>
        </div>

        <!-- Form -->
        <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
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
                        <!-- Dropdown Role -->
                        <div class="form-group row">
                            <label for="role_id" class="col-md-4 col-form-label text-md-right">Role</label>

                            <div class="col-md-6">
                                <select id="role_id" class="form-control" name="role_id" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin">Admin</option>
                                    <option value="spv">SPV</option>
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
    </div>
</div>



@endsection