<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
        protected $fillable = ['nis', 'nama', 'kelas', 'jurusan', 'sekolah_id', 'tgl_masuk', 'jenis_kelamin'];
    public function school()
    {
        return $this->belongsTo(School::class, 'sekolah_id');
    }
}
