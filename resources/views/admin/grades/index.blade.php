@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Nilai Siswa</h2>
    <a href="{{ route('admin.grades.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Tambah Nilai
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-4 font-bold text-gray-800">Siswa</th>
                    <th class="p-4 font-bold text-gray-800">Mata Pelajaran</th>
                    <th class="p-4 font-bold text-gray-800">Tugas</th>
                    <th class="p-4 font-bold text-gray-800">UTS</th>
                    <th class="p-4 font-bold text-gray-800">UAS</th>
                    <th class="p-4 font-bold text-gray-800">Total</th>
                    <th class="p-4 font-bold text-gray-800">Guru</th>
                    <th class="p-4 font-bold text-gray-800">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                <tr class="border-b last:border-0 hover:bg-gray-50">
                    <td class="p-4">
                        <div class="font-bold">{{ $grade->student->name }}</div>
                        <div class="text-xs text-gray-500">{{ $grade->student->username }}</div>
                    </td>
                    <td class="p-4">{{ $grade->subject->name }}</td>
                    <td class="p-4">{{ $grade->task_score }}</td>
                    <td class="p-4">{{ $grade->midterm_score }}</td>
                    <td class="p-4">{{ $grade->final_score }}</td>
                    <td class="p-4 font-bold text-blue-600">{{ $grade->total_score }}</td>
                    <td class="p-4">{{ $grade->teacher->name }}</td>
                    <td class="p-4">
                        <a href="{{ route('admin.grades.edit', $grade) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                        <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus nilai ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">
        {{ $grades->links() }}
    </div>
</div>
@endsection
