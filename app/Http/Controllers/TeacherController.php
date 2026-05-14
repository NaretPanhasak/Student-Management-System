<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $teachers = Teacher::paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|unique:teachers|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:teachers|max:255',
            'phone' => 'required|max:20',
            'subject' => 'required|max:255',
        ]);

        Teacher::create($request->all());

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher added successfully.');
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'teacher_id' => 'required|max:255|unique:teachers,teacher_id,' . $teacher->id,
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:teachers,email,' . $teacher->id,
            'phone' => 'required|max:20',
            'subject' => 'required|max:255',
        ]);

        $teacher->update($request->all());

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}
