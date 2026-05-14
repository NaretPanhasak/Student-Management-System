<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        // Create Departments
        $depts = [
            ['department_name' => 'Computer Science', 'description' => 'Focus on software and hardware systems.'],
            ['department_name' => 'Business Administration', 'description' => 'Focus on management and commerce.'],
            ['department_name' => 'Civil Engineering', 'description' => 'Focus on infrastructure and design.'],
        ];

        foreach ($depts as $dept) {
            Department::create($dept);
        }

        // Create Classes
        $classes = [
            ['class_name' => 'Year 1 - Section A', 'room' => 'R-101', 'description' => 'Freshman class.'],
            ['class_name' => 'Year 2 - Section B', 'room' => 'R-202', 'description' => 'Sophomore class.'],
            ['class_name' => 'Year 3 - Section C', 'room' => 'R-303', 'description' => 'Junior class.'],
        ];

        foreach ($classes as $class) {
            ClassModel::create($class);
        }

        // Create Teachers
        $teachers = [
            ['teacher_id' => 'TCH-001', 'name' => 'Dr. Robert Brown', 'email' => 'robert@university.com', 'phone' => '111222333', 'subject' => 'Computer Science'],
            ['teacher_id' => 'TCH-002', 'name' => 'Prof. Sarah Miller', 'email' => 'sarah@university.com', 'phone' => '444555666', 'subject' => 'Business Admin'],
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }

        // Create Some Students
        Student::create([
            'student_id' => 'STU-001',
            'name' => 'Alice Johnson',
            'gender' => 'Female',
            'dob' => '2005-05-15',
            'email' => 'alice@example.com',
            'phone' => '123456789',
            'address' => '123 Main St, New York',
            'class_id' => 1,
            'department_id' => 1,
        ]);

        Student::create([
            'student_id' => 'STU-002',
            'name' => 'Bob Smith',
            'gender' => 'Male',
            'dob' => '2004-10-20',
            'email' => 'bob@example.com',
            'phone' => '987654321',
            'address' => '456 Oak Ave, Los Angeles',
            'class_id' => 2,
            'department_id' => 2,
        ]);
    }
}
