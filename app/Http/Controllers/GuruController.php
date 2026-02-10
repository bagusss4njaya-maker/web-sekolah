<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = Auth::id();
        $q = $request->input('q');

        // Counts
        $totalStudents = User::where('role', 'siswa')->count(); // For now, global count
        
        // My Schedules
        $schedules = Schedule::with(['subject', 'teacher']) // Eager load teacher too if needed, though it's me
            ->where('teacher_id', $teacherId)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
            
        $totalSchedules = $schedules->count();
        
        // My Subjects (derived from schedules)
        $mySubjectIds = $schedules->pluck('subject_id')->unique();
        $subjects = Subject::whereIn('id', $mySubjectIds)->get();
        $totalSubjects = $subjects->count();

        // Recent Grades given by me
        $recentGrades = Grade::with(['student', 'subject'])
            ->where('teacher_id', $teacherId)
            ->latest()
            ->take(5)
            ->get();
            
        $studentsQuery = User::where('role', 'siswa');
        if ($q) {
            $studentsQuery->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('username', 'like', "%{$q}%")
                    ->orWhere('nis', 'like', "%{$q}%")
                    ->orWhere('major', 'like', "%{$q}%");
            });
        }
        $students = $q
            ? $studentsQuery->latest()->paginate(10)->appends(['q' => $q])
            : $studentsQuery->latest()->take(5)->get();

        return view('guru.dashboard', compact(
            'totalStudents',
            'totalSubjects',
            'totalSchedules',
            'schedules',
            'subjects',
            'recentGrades',
            'students',
            'q'
        ));
    }
}
