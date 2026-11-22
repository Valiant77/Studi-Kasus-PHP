<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;
    public const KELAS = [
        'X-XII' => ['X', 'XI', 'XII'],
        'X-XIII' => ['X', 'XI', 'XII', 'XIII']
    ];
    protected $table = 'schools';
    protected $fillable = ['npsn', 'nama', 'alamat', 'kuota', 'kelas', 'jurusan', 'terisi'];
    protected $casts = ['jurusan' => 'array'];

    public function kelasList(): array
    {
        return self::KELAS[$this->kelas] ?? [];
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'sekolah_id');
    }
    public function syncTerisi(): void
    {
        $this->update(['terisi' => $this->students()->count()]);
    }
}
