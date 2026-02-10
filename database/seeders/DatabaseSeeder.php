<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\SchoolClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'administrator',
            'username' => 'admin',
            'email' => 'admin@school.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Guru
        $guru = User::create([
            'name' => 'Budi Guru',
            'username' => 'guru',
            'email' => 'guru@school.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => '19800101200001',
        ]);

        // Kelas
        $kelas = SchoolClass::create([
            'name' => '10A',
            'major' => 'IPA',
            'teacher_id' => $guru->id,
        ]);

        // Siswa
        $siswa = User::create([
            'name' => 'Ani Siswa',
            'username' => 'siswa',
            'email' => 'siswa@school.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'nis' => '2024001',
            'major' => 'IPA',
            'school_class_id' => $kelas->id,
        ]);

        // Subjects
        $math = Subject::create(['name' => 'Matematika', 'description' => 'Pelajaran Matematika Dasar']);
        $ipa = Subject::create(['name' => 'IPA', 'description' => 'Ilmu Pengetahuan Alam']);
        $ind = Subject::create(['name' => 'Bahasa Indonesia', 'description' => 'Bahasa Nasional']);

        // Schedules
        Schedule::create([
            'subject_id' => $math->id,
            'teacher_id' => $guru->id,
            'class_name' => '10A',
            'day' => 'Senin',
            'start_time' => '08:00',
            'end_time' => '09:30',
        ]);

        Schedule::create([
            'subject_id' => $ipa->id,
            'teacher_id' => $guru->id,
            'class_name' => '10A',
            'day' => 'Selasa',
            'start_time' => '10:00',
            'end_time' => '11:30',
        ]);

        // Grades
        Grade::create([
            'student_id' => $siswa->id,
            'subject_id' => $math->id,
            'teacher_id' => $guru->id,
            'task_score' => 80,
            'midterm_score' => 85,
            'final_score' => 90,
            'total_score' => (80 * 0.3) + (85 * 0.3) + (90 * 0.4),
        ]);

        Grade::create([
            'student_id' => $siswa->id,
            'subject_id' => $ipa->id,
            'teacher_id' => $guru->id,
            'task_score' => 85,
            'midterm_score' => 90,
            'final_score' => 95,
            'total_score' => (85 * 0.3) + (90 * 0.3) + (95 * 0.4),
        ]);
    }
}
