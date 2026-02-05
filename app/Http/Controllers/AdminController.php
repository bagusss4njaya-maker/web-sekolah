<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Grade;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Counts
        $totalStudents = User::where('role', 'siswa')->count();
        $totalTeachers = User::where('role', 'guru')->count();
        $totalSubjects = Subject::count();
        $totalSchedules = Schedule::count();

        // Recent Data
        $recentStudents = User::where('role', 'siswa')->latest()->take(5)->get();
        $recentTeachers = User::where('role', 'guru')->latest()->take(5)->get();
        
        // Schedules (Ordered by day/time, just showing all or limited for dashboard)
        $schedules = Schedule::with(['subject', 'teacher'])
            ->orderBy('day')
            ->orderBy('start_time')
            ->take(5)
            ->get();
            
        // Recent Grades
        $recentGrades = Grade::with(['student', 'subject', 'teacher'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudents', 
            'totalTeachers', 
            'totalSubjects', 
            'totalSchedules',
            'recentStudents',
            'recentTeachers',
            'schedules',
            'recentGrades'
        ));
    }
}
