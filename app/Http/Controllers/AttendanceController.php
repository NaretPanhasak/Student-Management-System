<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $classes = ClassModel::all();
        $class_id = $request->get('class_id');
        $date = $request->get('date', date('Y-m-d'));

        $students = [];
        if ($class_id) {
            $students = Student::where('class_id', $class_id)->get();
        }

        // Get existing attendance for these students on this date
        $existing_attendance = Attendance::where('attendance_date', $date)
            ->whereIn('student_id', collect($students)->pluck('id'))
            ->get()
            ->keyBy('student_id');

        return view('attendance.index', compact('classes', 'students', 'class_id', 'date', 'existing_attendance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:Present,Absent,Late'
        ]);

        foreach ($request->attendance as $student_id => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'attendance_date' => $request->date
                ],
                [
                    'status' => $status,
                    'remarks' => $request->remarks[$student_id] ?? null
                ]
            );
        }

        return redirect()->back()->with('success', 'Attendance recorded successfully for ' . $request->date);
    }
}
