@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Siswa</h2>
    <div class="flex items-center space-x-2">
        <form method="GET" action="{{ route('admin.students.index') }}" class="flex items-center">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama, email, NIS, kelas" class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <button type="submit" class="ml-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-3 py-2 rounded">Cari</button>
        </form>
        <a href="{{ route('admin.students.create') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-200">
            Tambah Siswa
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="p-4 font-semibold text-gray-700 uppercase text-xs tracking-wider">Name</th>
                <th class="p-4 font-semibold text-gray-700 uppercase text-xs tracking-wider">Email</th>
                <th class="p-4 font-semibold text-gray-700 uppercase text-xs tracking-wider">NIS</th>
                <th class="p-4 font-semibold text-gray-700 uppercase text-xs tracking-wider">Class</th>
                <th class="p-4 font-semibold text-gray-700 uppercase text-xs tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($students as $student)
            <tr class="hover:bg-gray-50 transition duration-150">
                <td class="p-4 text-gray-900 font-medium">{{ $student->name }}</td>
                <td class="p-4 text-gray-600">{{ $student->email }}</td>
                <td class="p-4 text-gray-600">{{ $student->nis }}</td>
                <td class="p-4 text-gray-600">{{ $student->class_name }}</td>
                <td class="p-4 space-x-1">
                    <a href="{{ route('admin.students.edit', $student) }}" title="Edit" class="inline-flex items-center justify-center w-8 h-8 rounded hover:bg-indigo-50 text-indigo-600">✏️</a>
                    <form action="{{ route('admin.students.reset-password', $student) }}" method="POST" class="inline" onsubmit="return confirm('Reset password siswa ini ke NIS?');">
                        @csrf
                        <button type="submit" title="Reset Password" class="inline-flex items-center justify-center w-8 h-8 rounded hover:bg-yellow-50 text-yellow-600">🔑</button>
                    </form>
                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Delete" class="inline-flex items-center justify-center w-8 h-8 rounded hover:bg-red-50 text-red-600">🗑️</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4 bg-gray-50 border-t border-gray-200">
        {{ $students->links() }}
    </div>
</div>
@endsection
