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

    protected static function booted(): void //foid?????!!!!
    {
        static::created(fn ($s) => School::find($s->sekolah_id)?->syncTerisi());
        static::deleted(fn ($s) => School::find($s->sekolah_id)?->syncTerisi());

        static::updated(function ($s) {
            $old = $s->getOriginal('sekolah_id');

            if ($old != $s->sekolah_id) {
                School::find($old)?->syncTerisi();
                School::find($s->sekolah_id)?->syncTerisi();
            }
        });
    }
}
