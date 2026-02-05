<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['student', 'subject'])
            ->where('teacher_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('guru.grades.index', compact('grades'));
    }

    public function create()
    {
        $students = User::where('role', 'siswa')->get();
        $subjects = Subject::all();
        return view('guru.grades.create', compact('students', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'task_score' => 'required|integer|min:0|max:100',
            'midterm_score' => 'required|integer|min:0|max:100',
            'final_score' => 'required|integer|min:0|max:100',
        ]);

        $validated['teacher_id'] = Auth::id();
        $validated['total_score'] = ($validated['task_score'] * 0.3) + 
                                    ($validated['midterm_score'] * 0.3) + 
                                    ($validated['final_score'] * 0.4);

        Grade::create($validated);

        return redirect()->route('guru.grades.index')->with('success', 'Nilai berhasil ditambahkan.');
    }

    public function edit(Grade $grade)
    {
        if ($grade->teacher_id !== Auth::id()) {
            abort(403);
        }

        $students = User::where('role', 'siswa')->get();
        $subjects = Subject::all();
        return view('guru.grades.edit', compact('grade', 'students', 'subjects'));
    }

    public function update(Request $request, Grade $grade)
    {
        if ($grade->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'task_score' => 'required|integer|min:0|max:100',
            'midterm_score' => 'required|integer|min:0|max:100',
            'final_score' => 'required|integer|min:0|max:100',
        ]);

        $validated['total_score'] = ($validated['task_score'] * 0.3) + 
                                    ($validated['midterm_score'] * 0.3) + 
                                    ($validated['final_score'] * 0.4);

        $grade->update($validated);

        return redirect()->route('guru.grades.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Grade $grade)
    {
        if ($grade->teacher_id !== Auth::id()) {
            abort(403);
        }
        $grade->delete();
        return redirect()->route('guru.grades.index')->with('success', 'Nilai berhasil dihapus.');
    }
}
