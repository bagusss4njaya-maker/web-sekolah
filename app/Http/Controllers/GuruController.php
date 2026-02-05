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
    public function index()
    {
        $teacherId = Auth::id();

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
            
        // All students (limit for dashboard view)
        $students = User::where('role', 'siswa')->take(5)->get();

        return view('guru.dashboard', compact(
            'totalStudents',
            'totalSubjects',
            'totalSchedules',
            'schedules',
            'subjects',
            'recentGrades',
            'students'
        ));
    }
}
