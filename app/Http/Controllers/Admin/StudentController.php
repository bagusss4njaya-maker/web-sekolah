<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'siswa')->with('schoolClass')->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        return view('admin.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'nullable|string|min:8',
            'nis' => 'required|string|unique:users',
            'major' => 'required|string',
            'school_class_id' => 'required|exists:school_classes,id',
            'tahun_masuk' => 'required|integer|min:1900|max:2100',
            'status_siswa' => 'required|in:aktif,lulus,pindah,keluar',
            'tahun_lulus' => 'nullable|integer|min:1900|max:2100',
        ]);

        $validated['role'] = 'siswa';
        $validated['status_awal'] = $validated['status_siswa'];
        // Use NIS as default password if not provided
        $password = $request->filled('password') ? $request->password : $validated['nis'];
        $validated['password'] = Hash::make($password);
        $validated['must_change_password'] = true;
        if ($validated['status_siswa'] === 'lulus' && empty($validated['tahun_lulus'])) {
            $validated['tahun_lulus'] = (int) now()->year;
        }

        User::create($validated);

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil ditambahkan. Password default: NIS');
    }

    public function edit(User $student)
    {
        $classes = SchoolClass::all();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, User $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($student->id)],
            'nis' => ['required', 'string', Rule::unique('users')->ignore($student->id)],
            'major' => 'required|string',
            'school_class_id' => 'required|exists:school_classes,id',
            'tahun_masuk' => 'required|integer|min:1900|max:2100',
            'status_siswa' => 'required|in:aktif,lulus,pindah,keluar',
            'tahun_lulus' => 'nullable|integer|min:1900|max:2100',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
            $validated['must_change_password'] = true;
        }
        if ($validated['status_siswa'] === 'lulus' && empty($validated['tahun_lulus'])) {
            $validated['tahun_lulus'] = (int) now()->year;
        }

        $student->update($validated);

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function resetPassword(User $student)
    {
        $student->update([
            'password' => Hash::make($student->nis),
            'must_change_password' => true,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Password siswa berhasil direset ke NIS.');
    }

    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
