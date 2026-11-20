<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\School;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        return view('siswa', [
            'students' => Student::with('school')->paginate(10),
            'schools'  => School::orderBy('nama')->get(),
            'editing'  => $request->filled('edit') ? Student::find($request->edit) : null,
        ]);
    }

    public function store(Request $request)
    {
        Student::create($this->validated($request));

        return redirect()->route('siswa')->with('success', 'Siswa ditambahkan.');
    }

    public function update(Request $request, Student $student)
    {
        $student->update($this->validated($request, $student));

        return redirect()->route('siswa')->with('success', 'Siswa diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('siswa')->with('success', 'Siswa dihapus.');
    }

    private function validated(Request $request, ?Student $student = null): array
    {
        return $request->validate([
            'nis' => ['required', 'regex:/^[0-9]+$/', 'max:20', Rule::unique('students', 'nis')->ignore($student)],
            'nama' => ['required', 'regex:/^[\pL\s.\'-]+$/u', 'max:255'],
            'kelas' => ['required', Rule::in(Student::KELAS)],
            'jurusan' => ['required', Rule::in(Student::JURUSAN)],
            'sekolah_id' => ['required', 'exists:schools,id', function ($attr, $value, $fail) use ($student) { //this convolution because the stupid shit fill
                $school = School::find($value);
                $sameSchool = $student && $student->school_id == $value;
                if ($school && ! $sameSchool && $school->terisi >= $school->kuota) { $fail('Kuota sekolah ini sudah penuh.'); }
            }],
            'tgl_masuk'     => 'required|date',
            'jenis_kelamin' => ['required', Rule::in(['laki-laki', 'perempuan'])],
        ]);
    }
}
