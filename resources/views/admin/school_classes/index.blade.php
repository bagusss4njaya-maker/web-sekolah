@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Data Kelas</h2>
        <a href="{{ route('admin.school_classes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Kelas
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-4 font-bold text-gray-800">Nama Kelas</th>
                    <th class="p-4 font-bold text-gray-800">Jurusan</th>
                    <th class="p-4 font-bold text-gray-800">Wali Kelas</th>
                    <th class="p-4 font-bold text-gray-800">Jumlah Siswa</th>
                    <th class="p-4 font-bold text-gray-800">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                <tr class="border-b last:border-0 hover:bg-gray-50">
                    <td class="p-4">{{ $class->name }}</td>
                    <td class="p-4">{{ $class->major }}</td>
                    <td class="p-4">
                        @if($class->teacher)
                            <div class="font-bold">{{ $class->teacher->name }}</div>
                            <div class="text-xs text-gray-500">{{ $class->teacher->username }}</div>
                        @else
                            -
                        @endif
                    </td>
                    <td class="p-4">{{ $class->students()->count() }}</td>
                    <td class="p-4">
                        <a href="{{ route('admin.school_classes.edit', $class) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                        <form action="{{ route('admin.school_classes.destroy', $class) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Belum ada data kelas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $classes->links() }}
    </div>
</div>
@endsection
