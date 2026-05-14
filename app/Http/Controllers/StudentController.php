<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Department;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Student::with(['department', 'class']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_id', 'LIKE', "%$search%")
                  ->orWhere('name', 'LIKE', "%$search%");
            });
        }

        if ($request->has('department_id') && $request->department_id != '') {
            $query->where('department_id', $request->department_id);
        }

        if ($request->has('class_id') && $request->class_id != '') {
            $query->where('class_id', $request->class_id);
        }

        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }

        $students = $query->paginate(10)->withQueryString();
        $departments = Department::all();
        $classes = ClassModel::all();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('students.partials.student_rows', compact('students'))->render(),
                'pagination' => view('students.partials.pagination_footer', compact('students'))->render()
            ]);
        }

        return view('students.index', compact('students', 'departments', 'classes'));
    }

    public function create()
    {
        $departments = Department::all();
        $classes = ClassModel::all();
        return view('students.create', compact('departments', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|unique:students|max:255',
            'name' => 'required|max:255',
            'gender' => 'required',
            'dob' => 'required|date',
            'email' => 'required|email|unique:students|max:255',
            'phone' => 'required|max:20',
            'address' => 'required',
            'class_id' => 'required|exists:classes,id',
            'department_id' => 'required|exists:departments,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('students', 'public');
            $data['photo'] = $imagePath;
        }

        Student::create($data);

        return redirect()->route('students.index')
            ->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $departments = Department::all();
        $classes = ClassModel::all();
        return view('students.edit', compact('student', 'departments', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_id' => 'required|max:255|unique:students,student_id,' . $student->id,
            'name' => 'required|max:255',
            'gender' => 'required',
            'dob' => 'required|date',
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,
            'phone' => 'required|max:20',
            'address' => 'required',
            'class_id' => 'required|exists:classes,id',
            'department_id' => 'required|exists:departments,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $imagePath = $request->file('photo')->store('students', 'public');
            $data['photo'] = $imagePath;
        }

        $student->update($data);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    public function export()
    {
        $students = Student::with(['department', 'class'])->get();
        $csvFileName = 'students_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Student ID', 'Name', 'Gender', 'DOB', 'Email', 'Phone', 'Address', 'Class', 'Department'];

        $callback = function() use($students, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($students as $student) {
                fputcsv($file, [
                    $student->student_id,
                    $student->name,
                    $student->gender,
                    $student->dob,
                    $student->email,
                    $student->phone,
                    $student->address,
                    $student->class->class_name,
                    $student->department->department_name,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
