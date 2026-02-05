<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'nip',
        'nis',
        'major',
        'school_class_id',
        'must_change_password',
        'tahun_masuk',
        'status_awal',
        'status_siswa',
        'tahun_lulus',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'must_change_password' => 'boolean',
            'tahun_masuk' => 'integer',
            'tahun_lulus' => 'integer',
        ];
    }

    public function getClassNameAttribute()
    {
        return $this->schoolClass->name ?? '-';
    }

    // Teacher relationships
    public function teacherSchedules()
    {
        return $this->hasMany(Schedule::class, 'teacher_id');
    }

    public function teacherGrades()
    {
        return $this->hasMany(Grade::class, 'teacher_id');
    }

    public function managedClass()
    {
        return $this->hasOne(SchoolClass::class, 'teacher_id');
    }

    // Student relationships
    public function studentGrades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
}
