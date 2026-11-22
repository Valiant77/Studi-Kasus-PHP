<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use Illuminate\Validation\Rule;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $schools = School::paginate(10);
        $editing = $request->filled('edit') ? School::find($request->edit) : null;

        return view('sekolah', compact('schools', 'editing'));
    }

    public function store(Request $request)
    {
        School::create($this->validated($request));
        return redirect()->route('sekolah')->with('success', 'Sekolah ditambahkan.');
    }

    public function update(Request $request, School $school)
    {
        $school->update($this->validated($request, $school));
        return redirect()->route('sekolah')->with('success', 'Sekolah diperbarui.');
    }

    public function destroy(School $school)
    {
        $school->delete();
        return redirect()->route('sekolah')->with('success', 'Sekolah dihapus.');
    }

    private function validated(Request $request, ?School $school = null): array
    {
        $data = $request->validate([
            'npsn'    => ['required', 'regex:/^[0-9]{8}$/', Rule::unique('schools', 'npsn')->ignore($school)],
            'nama'    => 'required|string|max:255',
            'alamat'  => 'required|string|max:255',
            'kuota'   => ['required', 'integer', 'min:' . ($school?->terisi ?? 0)],
            'kelas'   => ['required', Rule::in(array_keys(School::KELAS))],
            'jurusan' => 'required|string|max:500',
        ], [
            'npsn.regex' => 'NPSN harus 8 digit angka.',
        ]);

        $data['jurusan'] = collect(explode(',', $data['jurusan']))
            ->map(fn ($j) => trim($j))
            ->filter()
            ->unique(fn ($j) => strtolower($j))
            ->values()
            ->all();

        return $data;
    }
}
