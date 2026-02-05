<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index()
    {
        $student = Auth::user()->load('schoolClass');
        
        // My Schedules
        // Match schedule class_name with student's schoolClass name
        $className = $student->schoolClass ? $student->schoolClass->name : null;

        $schedules = Schedule::with(['subject', 'teacher'])
            ->where('class_name', $className)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
            
        $totalSchedules = $schedules->count();

        // My Subjects (derived from schedules)
        $subjectIds = $schedules->pluck('subject_id')->unique();
        $subjects = Subject::whereIn('id', $subjectIds)->get();
        $totalSubjects = $subjects->count();

        // My Recent Grades
        $grades = Grade::with(['subject', 'teacher'])
            ->where('student_id', $student->id)
            ->latest()
            ->take(5)
            ->get();
            
        // Calculate Average Score
        $allGrades = Grade::where('student_id', $student->id)->get();
        $averageScore = $allGrades->count() > 0 ? round($allGrades->avg('total_score'), 1) : 0;

        return view('siswa.dashboard', compact(
            'student', 
            'subjects', 
            'schedules', 
            'grades',
            'totalSubjects',
            'totalSchedules',
            'averageScore'
        ));
    }
}
