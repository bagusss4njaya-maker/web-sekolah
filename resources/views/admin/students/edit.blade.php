@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Siswa</h2>
        <a href="{{ route('admin.students.index') }}" class="text-gray-600 hover:text-gray-800">Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.students.update', $student) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nama Lengkap</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" value="{{ old('name', $student->name) }}" required>
                @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" name="username" value="{{ old('username', $student->username) }}" required>
                @error('username') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-2 text-sm" role="alert">
                    <p>Password saat ini terenkripsi dan tidak dapat ditampilkan demi keamanan.</p>
                    <p>• Kosongkan kolom ini jika ingin <strong>mempertahankan</strong> password lama.</p>
                    <p>• Isi kolom ini HANYA jika ingin <strong>mengganti</strong> password.</p>
                </div>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password" placeholder="Isi password baru disini jika ingin mengubah...">
                @error('password') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nis">NIS</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nis" type="text" name="nis" value="{{ old('nis', $student->nis) }}" required>
                @error('nis') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="major">Jurusan</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="major" type="text" name="major" value="{{ old('major', $student->major) }}" required placeholder="Contoh: IPA">
                @error('major') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="school_class_id">Kelas</label>
                <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="school_class_id" name="school_class_id" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('school_class_id', $student->school_class_id) == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_class_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="tahun_masuk">Tahun Masuk</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tahun_masuk" type="number" name="tahun_masuk" value="{{ old('tahun_masuk', $student->tahun_masuk) }}" required placeholder="Contoh: 2023" min="1900" max="2100">
                @error('tahun_masuk') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status_siswa">Status</label>
                <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="status_siswa" name="status_siswa" required>
                    <option value="">-- Pilih Status --</option>
                    @php $status = old('status_siswa', $student->status_siswa); @endphp
                    <option value="aktif" {{ $status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="lulus" {{ $status === 'lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="pindah" {{ $status === 'pindah' ? 'selected' : '' }}>Pindah</option>
                    <option value="keluar" {{ $status === 'keluar' ? 'selected' : '' }}>Keluar</option>
                </select>
                @error('status_siswa') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="tahun_lulus">Tahun Lulus (Opsional)</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tahun_lulus" type="number" name="tahun_lulus" value="{{ old('tahun_lulus', $student->tahun_lulus) }}" placeholder="Isi hanya jika status Lulus" min="1900" max="2100">
                @error('tahun_lulus') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
