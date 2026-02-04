@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <div class="row">
        {{-- Bagian Profile --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    {{-- Foto Profil --}}
                   <img id="profile-photo-preview" class="profile-user-img img-fluid img-circle"
               src="{{ asset(!empty($user->photo) ? $user->photo : 'Template/dist/img/usernew.png') }}"
                 alt="User profile picture" style="width: 150px; height: 150px; object-fit: cover;">

                    <h4>{{ auth()->user()->name }}</h4>
                    <p class="text-muted">{{ auth()->user()->email }}</p>

                    {{-- Form ganti foto --}}
                    <form action="{{ route('profile.updatephoto') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="file" name="photo" class="form-control mb-2" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Ganti Foto</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bagian Ganti Password --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Ganti Password</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.updatepassword') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="current_password">Password Saat Ini</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="new_password">Password Baru</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Perbarui Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
