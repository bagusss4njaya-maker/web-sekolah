@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Tambah Nilai</h2>
        <a href="{{ route('guru.grades.index') }}" class="text-gray-600 hover:text-gray-800">Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('guru.grades.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="student_id">Siswa</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="student_id" name="student_id" required>
                    <option value="">Pilih Siswa</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }} ({{ $student->nis }})</option>
                    @endforeach
                </select>
                @error('student_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="subject_id">Mata Pelajaran</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="subject_id" name="subject_id" required>
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
                @error('subject_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="task_score">Nilai Tugas</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="task_score" type="number" min="0" max="100" name="task_score" value="{{ old('task_score', 0) }}" required>
                    @error('task_score') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="midterm_score">Nilai UTS</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="midterm_score" type="number" min="0" max="100" name="midterm_score" value="{{ old('midterm_score', 0) }}" required>
                    @error('midterm_score') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="final_score">Nilai UAS</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="final_score" type="number" min="0" max="100" name="final_score" value="{{ old('final_score', 0) }}" required>
                    @error('final_score') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
