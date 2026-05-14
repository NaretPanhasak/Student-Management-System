<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', function () {
    return redirect()->route('dashboard');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('students/export', [StudentController::class, 'export'])->name('students.export');
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('classes', ClassController::class);
    Route::resource('departments', DepartmentController::class);

    // Attendance Routes
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('attendance', [AttendanceController::class, 'store'])->name('attendance.store');
});

// ⚠️ TEMPORARY DEPLOYMENT ROUTE (Delete after first use on InfinityFree)
use Illuminate\Support\Facades\Artisan;
Route::get('/deploy-database', function () {
    try {
        Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
        return "<h1>✅ Database Migrated & Seeded Successfully!</h1><p>You can now go to <a href='/login'>Login</a>.</p>";
    } catch (\Exception $e) {
        return "<h1>❌ Error:</h1><pre>" . $e->getMessage() . "</pre>";
    }
});
