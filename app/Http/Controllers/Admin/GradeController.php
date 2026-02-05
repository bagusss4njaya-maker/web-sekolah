<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['student', 'subject', 'teacher'])->latest()->paginate(10);
        return view('admin.grades.index', compact('grades'));
    }

    public function create()
    {
        $students = User::where('role', 'siswa')->get();
        $teachers = User::where('role', 'guru')->get();
        $subjects = Subject::all();
        return view('admin.grades.create', compact('students', 'teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'task_score' => 'required|integer|min:0|max:100',
            'midterm_score' => 'required|integer|min:0|max:100',
            'final_score' => 'required|integer|min:0|max:100',
        ]);

        // Calculate total score (30% Task, 30% Midterm, 40% Final)
        $validated['total_score'] = ($validated['task_score'] * 0.3) + 
                                    ($validated['midterm_score'] * 0.3) + 
                                    ($validated['final_score'] * 0.4);

        Grade::create($validated);

        return redirect()->route('admin.grades.index')->with('success', 'Nilai berhasil ditambahkan.');
    }

    public function edit(Grade $grade)
    {
        $students = User::where('role', 'siswa')->get();
        $teachers = User::where('role', 'guru')->get();
        $subjects = Subject::all();
        return view('admin.grades.edit', compact('grade', 'students', 'teachers', 'subjects'));
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'task_score' => 'required|integer|min:0|max:100',
            'midterm_score' => 'required|integer|min:0|max:100',
            'final_score' => 'required|integer|min:0|max:100',
        ]);

        // Calculate total score
        $validated['total_score'] = ($validated['task_score'] * 0.3) + 
                                    ($validated['midterm_score'] * 0.3) + 
                                    ($validated['final_score'] * 0.4);

        $grade->update($validated);

        return redirect()->route('admin.grades.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('admin.grades.index')->with('success', 'Nilai berhasil dihapus.');
    }
}
