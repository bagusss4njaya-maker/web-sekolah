@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Guru</h2>
    <div class="flex items-center space-x-2">
        <form method="GET" action="{{ route('admin.teachers.index') }}" class="flex items-center">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama, email, username, NIP" class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <button type="submit" class="ml-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-3 py-2 rounded">Cari</button>
        </form>
        <a href="{{ route('admin.teachers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Guru
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 font-bold text-gray-800">Name</th>
                <th class="p-4 font-bold text-gray-800">Username</th>
                <th class="p-4 font-bold text-gray-800">NIP</th>
                <th class="p-4 font-bold text-gray-800">Email</th>
                <th class="p-4 font-bold text-gray-800">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
            <tr class="border-b last:border-0 hover:bg-gray-50">
                <td class="p-4">{{ $teacher->name }}</td>
                <td class="p-4">{{ $teacher->username }}</td>
                <td class="p-4">{{ $teacher->nip }}</td>
                <td class="p-4">{{ $teacher->email }}</td>
                <td class="p-4">
                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                    <form action="{{ route('admin.teachers.reset-password', $teacher) }}" method="POST" class="inline mr-3" onsubmit="return confirm('Reset password guru ini ke NIP?');">
                        @csrf
                        <button type="submit" class="text-yellow-600 hover:text-yellow-900">Reset Pwd</button>
                    </form>
                    <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4">
        {{ $teachers->links() }}
    </div>
</div>
@endsection
