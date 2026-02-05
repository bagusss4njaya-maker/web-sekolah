@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Kelas</h2>
        <a href="{{ route('admin.school_classes.index') }}" class="text-gray-600 hover:text-gray-900">
            &larr; Kembali
        </a>
    </div>

    <form action="{{ route('admin.school_classes.update', $schoolClass) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Kelas</label>
            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name', $schoolClass->name) }}" required>
            @error('name')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="major" class="block text-gray-700 text-sm font-bold mb-2">Jurusan</label>
            <input type="text" name="major" id="major" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('major') border-red-500 @enderror" value="{{ old('major', $schoolClass->major) }}" required>
            @error('major')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="teacher_id" class="block text-gray-700 text-sm font-bold mb-2">Wali Kelas (Opsional)</label>
            <select name="teacher_id" id="teacher_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('teacher_id') border-red-500 @enderror">
                <option value="">-- Pilih Wali Kelas --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $schoolClass->teacher_id) == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }} ({{ $teacher->username }})
                    </option>
                @endforeach
            </select>
            @error('teacher_id')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Perbarui
            </button>
        </div>
    </form>
</div>
@endsection
