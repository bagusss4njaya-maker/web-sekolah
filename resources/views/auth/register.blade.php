@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[80vh] py-10">
    <div class="w-full max-w-lg bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Daftar Akun Baru</h2>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <!-- Common Fields -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nama Lengkap</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Konfirmasi Password</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <!-- Role Selection -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="role">Daftar Sebagai</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="role" name="role" required onchange="toggleFields()">
                    <option value="">-- Pilih Peran --</option>
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                </select>
            </div>

            <!-- Guru Fields -->
            <div id="guru-fields" class="hidden">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nip">NIP (Nomor Induk Pegawai)</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nip" type="text" name="nip" value="{{ old('nip') }}" placeholder="Masukkan NIP">
                </div>
            </div>

            <!-- Siswa Fields -->
            <div id="siswa-fields" class="hidden">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nis">NIS (Nomor Induk Siswa)</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nis" type="text" name="nis" value="{{ old('nis') }}" placeholder="Masukkan NIS">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="major">Jurusan</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="major" type="text" name="major" value="{{ old('major') }}" placeholder="Contoh: IPA">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="school_class_id">Kelas</label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="school_class_id" name="school_class_id">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('school_class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" type="submit">
                    Daftar Sekarang
                </button>
            </div>
            
            <div class="text-center mt-4">
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('login') }}">
                    Sudah punya akun? Login
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleFields() {
        const role = document.getElementById('role').value;
        const guruFields = document.getElementById('guru-fields');
        const siswaFields = document.getElementById('siswa-fields');
        
        // Reset visibility
        guruFields.classList.add('hidden');
        siswaFields.classList.add('hidden');
        
        // Remove required attributes to avoid validation errors on hidden fields (client-side)
        // Note: Server-side validation handles required_if logic properly
        
        if (role === 'guru') {
            guruFields.classList.remove('hidden');
        } else if (role === 'siswa') {
            siswaFields.classList.remove('hidden');
        }
    }

    // Run on load in case of validation errors redirecting back with old input
    document.addEventListener('DOMContentLoaded', toggleFields);
</script>
@endsection