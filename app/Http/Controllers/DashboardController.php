<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Department;
use App\Models\Teacher;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $stats = [
            'total_students' => Student::count(),
            'total_classes' => ClassModel::count(),
            'total_departments' => Department::count(),
            'total_teachers' => Teacher::count(),
            'present_today' => Attendance::where('attendance_date', date('Y-m-d'))->where('status', 'Present')->count(),
            'male_students' => Student::where('gender', 'Male')->count(),
            'female_students' => Student::where('gender', 'Female')->count(),
        ];

        $recent_students = Student::with(['class', 'department'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_students'));
    }
}
