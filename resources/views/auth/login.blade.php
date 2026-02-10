@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center h-[80vh]">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Login Sistem Akademik</h2>
        
        @if ($errors->any())
            <div class="bg-red-50 text-red-700 px-4 py-3 rounded relative mb-4 text-sm border border-red-200">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                <input class="shadow-sm border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email (opsional)">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                <input class="shadow-sm border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent" id="username" type="text" name="username" value="{{ old('username') }}" autofocus placeholder="Masukkan Username (opsional)">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <input class="shadow-sm border border-gray-300 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent" id="password" type="password" name="password" required placeholder="Masukkan Password">
            </div>
            <div class="space-y-3">
                <button class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full transition duration-300" type="submit" name="role_target" value="user">
                    Masuk sebagai Siswa / Guru
                </button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full transition duration-300" type="submit" name="role_target" value="admin">
                    Masuk sebagai Admin
                </button>
            </div>
        </form>
        
        <div class="mt-4 text-sm text-gray-600">
            <p class="font-semibold">Demo Accounts (Email atau Username / Password):</p>
            <ul class="list-disc ml-5 mt-1">
                <li>Admin: admin@school.com atau admin / password</li>
                <li>Guru: guru@school.com atau guru / password</li>
                <li>Siswa: siswa@school.com atau siswa / password</li>
            </ul>
        </div>
    </div>
</div>
@endsection
