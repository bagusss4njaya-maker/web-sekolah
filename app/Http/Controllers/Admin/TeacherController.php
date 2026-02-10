<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $query = User::where('role', 'guru');
        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('username', 'like', "%{$q}%")
                    ->orWhere('nip', 'like', "%{$q}%");
            });
        }
        $teachers = $query->latest()->paginate(10)->appends(['q' => $q]);
        return view('admin.teachers.index', compact('teachers', 'q'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'nullable|string|min:8',
            'nip' => 'required|string|unique:users',
        ]);

        $validated['role'] = 'guru';
        // Use NIP as default password if not provided
        $password = $request->filled('password') ? $request->password : $validated['nip'];
        $validated['password'] = Hash::make($password);
        $validated['must_change_password'] = true;

        User::create($validated);

        return redirect()->route('admin.teachers.index')->with('success', 'Guru berhasil ditambahkan. Password default: NIP');
    }

    public function edit(User $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, User $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($teacher->id)],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($teacher->id)],
            'nip' => ['required', 'string', Rule::unique('users')->ignore($teacher->id)],
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
            $validated['must_change_password'] = true;
        }

        $teacher->update($validated);

        return redirect()->route('admin.teachers.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function resetPassword(User $teacher)
    {
        $teacher->update([
            'password' => Hash::make($teacher->nip),
            'must_change_password' => true,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Password guru berhasil direset ke NIP.');
    }

    public function destroy(User $teacher)
    {
        $teacher->delete();
        return redirect()->route('admin.teachers.index')->with('success', 'Guru berhasil dihapus.');
    }
}
