@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Jadwal Pelajaran</h2>
    <a href="{{ route('admin.schedules.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Tambah Jadwal
    </a>
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
                <th class="p-4 font-bold text-gray-800">Hari</th>
                <th class="p-4 font-bold text-gray-800">Jam</th>
                <th class="p-4 font-bold text-gray-800">Kelas</th>
                <th class="p-4 font-bold text-gray-800">Mata Pelajaran</th>
                <th class="p-4 font-bold text-gray-800">Guru</th>
                <th class="p-4 font-bold text-gray-800">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
            <tr class="border-b last:border-0 hover:bg-gray-50">
                <td class="p-4">{{ $schedule->day }}</td>
                <td class="p-4">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                <td class="p-4">{{ $schedule->class_name }}</td>
                <td class="p-4">{{ $schedule->subject->name }}</td>
                <td class="p-4">
                    <div class="font-bold">{{ $schedule->teacher->name }}</div>
                    <div class="text-xs text-gray-500">{{ $schedule->teacher->username }}</div>
                </td>
                <td class="p-4">
                    <a href="{{ route('admin.schedules.edit', $schedule) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                    <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
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
        {{ $schedules->links() }}
    </div>
</div>
@endsection
