<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;

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
        $school->update($this->validated($request));
        return redirect()->route('sekolah')->with('success', 'Sekolah diperbarui.');
    }

    public function destroy(School $school)
    {
        $school->delete();
        return redirect()->route('sekolah')->with('success', 'Sekolah dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama'   => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'kuota'  => 'required|integer|min:0',
            'terisi' => 'required|integer|min:0|lte:kuota',
        ]);
    }
}
