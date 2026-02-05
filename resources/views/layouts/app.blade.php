<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Akademik Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans leading-normal tracking-normal text-gray-800">

    <nav class="bg-gray-800 p-4 shadow-lg text-white">
        <div class="container mx-auto flex flex-wrap justify-between items-center">
            <a href="#" class="font-bold text-xl tracking-tight">Sistem Akademik</a>
            
            @auth
            <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto mt-4 lg:mt-0">
                @if(Auth::user()->role === 'admin')
                <div class="text-sm lg:flex-grow lg:ml-6 space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white transition duration-200">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white transition duration-200">
                        Data Siswa
                    </a>
                    <a href="{{ route('admin.teachers.index') }}" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white transition duration-200">
                        Data Guru
                    </a>
                    <a href="{{ route('admin.schedules.index') }}" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white transition duration-200">
                        Jadwal
                    </a>
                    <a href="{{ route('admin.grades.index') }}" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white transition duration-200">
                        Nilai
                    </a>
                    <a href="{{ route('admin.school_classes.index') }}" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white transition duration-200">
                        Kelas
                    </a>
                    <a href="{{ route('admin.subjects.index') }}" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white transition duration-200">
                        Mapel
                    </a>
                </div>
                @endif
            
                <div class="flex items-center space-x-4 ml-auto">
                    <span class="text-gray-300">Hello, <span class="font-semibold text-white">{{ Auth::user()->name }}</span> ({{ Auth::user()->username }} - {{ ucfirst(Auth::user()->role) }})</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-1 px-3 rounded text-sm transition duration-200">Logout</button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </nav>

    <div class="container mx-auto mt-8 px-4">
        @yield('content')
    </div>

</body>
</html>
