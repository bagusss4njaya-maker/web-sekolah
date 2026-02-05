@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-600">Selamat datang di Sistem Akademik Sekolah</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-gray-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Siswa</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalStudents }}</h3>
            </div>
            <div class="bg-gray-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-gray-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Guru</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalTeachers }}</h3>
            </div>
            <div class="bg-gray-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-gray-400">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Pelajaran</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSubjects }}</h3>
            </div>
            <div class="bg-gray-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-gray-800">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Jadwal Aktif</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSchedules }}</h3>
            </div>
            <div class="bg-gray-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Data Siswa Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Data Siswa Terbaru</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">Name</th>
                            <th class="pb-3 font-medium">NIS</th>
                            <th class="pb-3 font-medium">Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentStudents as $student)
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="py-3 text-gray-800 font-medium">{{ $student->name }}</td>
                            <td class="py-3 text-gray-600">{{ $student->nis }}</td>
                            <td class="py-3 text-gray-600">{{ $student->class_name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('admin.students.index') }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">View All Students &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Data Guru Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Data Guru Terbaru</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">Name</th>
                            <th class="pb-3 font-medium">NIP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTeachers as $teacher)
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="py-3 text-gray-800 font-medium">{{ $teacher->name }}</td>
                            <td class="py-3 text-gray-600">{{ $teacher->nip }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('admin.teachers.index') }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">View All Teachers &rarr;</a>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Jadwal Pelajaran Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Jadwal Pelajaran</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">Day</th>
                            <th class="pb-3 font-medium">Time</th>
                            <th class="pb-3 font-medium">Class</th>
                            <th class="pb-3 font-medium">Subject</th>
                            <th class="pb-3 font-medium">Teacher</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="py-3 text-gray-800">{{ $schedule->day }}</td>
                            <td class="py-3 text-gray-600 text-sm">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                            <td class="py-3 text-gray-600">{{ $schedule->class_name }}</td>
                            <td class="py-3 text-gray-800 font-medium">{{ $schedule->subject->name }}</td>
                            <td class="py-3 text-gray-600">{{ $schedule->teacher->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('admin.schedules.index') }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">View Full Schedule &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Data Nilai Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Data Nilai Terbaru</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">Student</th>
                            <th class="pb-3 font-medium">Subject</th>
                            <th class="pb-3 font-medium">Score</th>
                            <th class="pb-3 font-medium">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentGrades as $grade)
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="py-3 text-gray-800 font-medium">{{ $grade->student->name }}</td>
                            <td class="py-3 text-gray-600">{{ $grade->subject->name }}</td>
                            <td class="py-3 text-gray-800 font-bold">{{ $grade->score }}</td>
                            <td class="py-3 text-gray-500 text-sm truncate max-w-xs">{{ $grade->description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('admin.grades.index') }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">View All Grades &rarr;</a>
            </div>
        </div>
    </div>
</div>
@endsection
