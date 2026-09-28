<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->get();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'nullable|string|max:100',
            'nis' => 'nullable|string|max:100|unique:students,nis',
        ]);

        Student::create($validated);

        return redirect()
            ->route('students.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'nullable|string|max:100',
            'nis' => 'nullable|string|max:100|unique:students,nis,' . $student->id,
        ]);

        $student->update($validated);

        return redirect()
            ->route('students.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}