<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = SchoolClass::with('teacher')->latest()->paginate(10);
        return view('admin.school_classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::where('role', 'guru')->get();
        return view('admin.school_classes.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:school_classes',
            'major' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        SchoolClass::create($request->all());

        return redirect()->route('admin.school_classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolClass $schoolClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolClass $schoolClass)
    {
        $teachers = User::where('role', 'guru')->get();
        return view('admin.school_classes.edit', compact('schoolClass', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $schoolClass)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:school_classes,name,' . $schoolClass->id,
            'major' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $schoolClass->update($request->all());

        return redirect()->route('admin.school_classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();
        return redirect()->route('admin.school_classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
