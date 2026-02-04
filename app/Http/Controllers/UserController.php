<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Tampilkan daftar user dengan pagination
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, function($q, $search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->orderBy('name', 'desc')
            ->paginate(10);

        return view('users.index', compact('users'));
    }
    /**
     * Tampilkan form untuk user baru
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Tampilkan form untuk mengedit profil user
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }
    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        // Cek apakah user dengan email atau username sudah ada
        $existingUser = User::where('email', $request->email)
            ->orWhere('username', $request->username)
            ->first();

        if ($existingUser) {
            return redirect()->back()->with('error', 'Username atau email sudah digunakan.');
        }

        // Buat user baru
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User registered successfully!');
    }

    /**
     * Update profil user
     */
    public function updatePhoto(Request $request)
    {
        $user = Auth::user();
        // Jika ada foto baru, simpan dan update path



        if ($request->hasFile('photo')) {       
        $image = $request->file('photo');
        $filename = 'profile_'.time().'.'.$image->getClientOriginalExtension();
        $path = 'uploads/profiles/';
        $image->move(public_path($path), $filename);
        
        $user->photo = $path.$filename;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }
    /**
     * Update password user
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Cek apakah password saat ini benar
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini salah.');
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Password updated successfully!');
    }

    /**
     * Update status user (untuk toggle aktif/nonaktif)
     */
    public function updateStatus(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Status tidak valid'], 400);
        }

        $user->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status user berhasil diupdate!'
        ]);
    }

    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        // dd($user);
        // Cek apakah user yang akan dihapus adalah user yang sedang login
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}