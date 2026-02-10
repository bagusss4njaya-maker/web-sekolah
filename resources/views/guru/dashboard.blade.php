@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Guru</h1>
    <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Siswa</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalStudents }}</h3>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Mata Pelajaran</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSubjects }}</h3>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Jadwal Saya</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSchedules }}</h3>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800">Cari Siswa</h3>
        <form method="GET" action="{{ route('guru.dashboard') }}" class="flex items-center">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama, email, username, NIS" class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <button type="submit" class="ml-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-3 py-2 rounded">Cari</button>
        </form>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-500 border-b border-gray-100">
                        <th class="pb-3 font-medium">Nama</th>
                        <th class="pb-3 font-medium">Email</th>
                        <th class="pb-3 font-medium">NIS</th>
                        <th class="pb-3 font-medium">Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr class="border-b border-gray-50 last:border-0">
                        <td class="py-3 text-gray-800 font-medium">{{ $student->name }}</td>
                        <td class="py-3 text-gray-600">{{ $student->email }}</td>
                        <td class="py-3 text-gray-600">{{ $student->nis }}</td>
                        <td class="py-3 text-gray-600">{{ $student->class_name ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(isset($q) && $q)
        <div class="mt-4">
            {{ $students->links() }}
        </div>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Jadwal Pelajaran Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Jadwal Mengajar Saya</h3>
        </div>
        <div class="p-6">
            @if($schedules->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">Hari</th>
                            <th class="pb-3 font-medium">Jam</th>
                            <th class="pb-3 font-medium">Kelas</th>
                            <th class="pb-3 font-medium">Mapel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="py-3 text-gray-800">{{ $schedule->day }}</td>
                            <td class="py-3 text-gray-600 text-sm">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                            <td class="py-3 text-gray-600">{{ $schedule->class_name }}</td>
                            <td class="py-3 text-gray-800 font-medium">{{ $schedule->subject->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500 text-center py-4">Belum ada jadwal mengajar.</p>
            @endif
        </div>
    </div>

    <!-- Data Nilai Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Nilai Siswa Terbaru (Diinput Saya)</h3>
            <a href="{{ route('guru.grades.index') }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">Kelola Nilai &rarr;</a>
        </div>
        <div class="p-6">
            @if($recentGrades->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">Siswa</th>
                            <th class="pb-3 font-medium">Mapel</th>
                            <th class="pb-3 font-medium">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentGrades as $grade)
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="py-3 text-gray-800 font-medium">{{ $grade->student->name }}</td>
                            <td class="py-3 text-gray-600">{{ $grade->subject->name }}</td>
                            <td class="py-3 text-gray-800 font-bold">{{ $grade->total_score }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500 text-center py-4">Belum ada nilai yang diinput.</p>
            @endif
        </div>
    </div>
</div>
@endsection
