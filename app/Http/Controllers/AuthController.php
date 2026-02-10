<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['nullable', 'string', 'email'],
            'username' => ['nullable', 'string'],
            'password' => ['required'],
        ]);

        // At least one identifier must be provided
        if (!$request->filled('email') && !$request->filled('username')) {
            throw ValidationException::withMessages([
                'email' => 'Email atau Username wajib diisi.',
                'username' => 'Email atau Username wajib diisi.',
            ]);
        }

        $email = $request->input('email') ? trim($request->input('email')) : null;
        $username = $request->input('username') ? trim($request->input('username')) : null;
        $password = $request->input('password');
        $roleTarget = $request->input('role_target', 'user'); // 'admin' atau 'user'

        // Find user by Email first, fallback to Username
        $user = null;
        if ($email) {
            $user = User::where('email', $email)->first();
        }
        if (!$user && $username) {
            $user = User::where('username', $username)->first();
        }

        if ($user && Hash::check($password, $user->password)) {
            // Pisahkan login berdasarkan tombol yang dipilih
            if ($roleTarget === 'admin' && $user->role !== 'admin') {
                throw ValidationException::withMessages([
                    'username' => 'Login ini khusus Admin.',
                ]);
            }
            if ($roleTarget === 'user' && $user->role === 'admin') {
                throw ValidationException::withMessages([
                    'username' => 'Gunakan tombol "Masuk sebagai Admin" untuk Admin.',
                ]);
            }

            Auth::login($user);
            $request->session()->regenerate();

            // Check if user must change password
            if ($user->must_change_password) {
                return redirect()->route('password.change');
            }

            return $this->redirectUser($user);
        }

        throw ValidationException::withMessages([
            'username' => __('auth.failed'),
        ]);
    }

    protected function redirectUser($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'guru') {
            return redirect()->route('guru.dashboard');
        } elseif ($user->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }
        
        return redirect('/');
    }

    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed|different:current_password',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return $this->redirectUser($user)->with('success', 'Password berhasil diubah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
