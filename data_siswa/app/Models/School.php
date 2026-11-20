<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;
    protected $table = 'schools';
    protected $fillable = ['nama', 'alamat', 'kuota', 'terisi'];
    public function students()
    {
        return $this->hasMany(Student::class, 'sekolah_id');
    }
    public function syncTerisi(): void
    {
        $this->update(['terisi' => $this->students()->count()]);
    }
}
