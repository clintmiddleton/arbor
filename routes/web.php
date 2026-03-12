<?php

use App\Http\Controllers\Admin\Classroom\ClassroomCreateController;
use App\Http\Controllers\Admin\Classroom\ClassroomDestroyController;
use App\Http\Controllers\Admin\Classroom\ClassroomEditController;
use App\Http\Controllers\Admin\Classroom\ClassroomIndexController;
use App\Http\Controllers\Admin\Classroom\ClassroomShowController;
use App\Http\Controllers\Admin\Classroom\ClassroomStoreController;
use App\Http\Controllers\Admin\Classroom\ClassroomUpdateController;
use App\Http\Controllers\Admin\Enrollment\EnrollmentDestroyController;
use App\Http\Controllers\Admin\Enrollment\EnrollmentIndexController;
use App\Http\Controllers\Admin\Enrollment\EnrollmentStoreController;
use App\Http\Controllers\Admin\Student\StudentCreateController;
use App\Http\Controllers\Admin\Student\StudentDestroyController;
use App\Http\Controllers\Admin\Student\StudentEditController;
use App\Http\Controllers\Admin\Student\StudentIndexController;
use App\Http\Controllers\Admin\Student\StudentShowController;
use App\Http\Controllers\Admin\Student\StudentStoreController;
use App\Http\Controllers\Admin\Student\StudentUpdateController;
use App\Http\Controllers\Admin\User\UserCreateController;
use App\Http\Controllers\Admin\User\UserDestroyController;
use App\Http\Controllers\Admin\User\UserEditController;
use App\Http\Controllers\Admin\User\UserIndexController;
use App\Http\Controllers\Admin\User\UserShowController;
use App\Http\Controllers\Admin\User\UserStoreController;
use App\Http\Controllers\Admin\User\UserUpdateController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/classrooms', ClassroomIndexController::class)->name('classrooms.index');
    Route::get('/classrooms/create', ClassroomCreateController::class)->name('classrooms.create');
    Route::post('/classrooms', ClassroomStoreController::class)->name('classrooms.store');
    Route::get('/classrooms/{classroom}', ClassroomShowController::class)->name('classrooms.show');
    Route::get('/classrooms/{classroom}/enrollments', EnrollmentIndexController::class)->name('classrooms.enrollments.index');
    Route::post('/classrooms/{classroom}/enrollments', EnrollmentStoreController::class)->name('classrooms.enrollments.store');
    Route::get('/classrooms/{classroom}/edit', ClassroomEditController::class)->name('classrooms.edit');
    Route::put('/classrooms/{classroom}', ClassroomUpdateController::class)->name('classrooms.update');
    Route::delete('/classrooms/{classroom}', ClassroomDestroyController::class)->name('classrooms.destroy');

    Route::get('/students', StudentIndexController::class)->name('students.index');
    Route::get('/students/create', StudentCreateController::class)->name('students.create');
    Route::post('/students', StudentStoreController::class)->name('students.store');
    Route::get('/students/{student}', StudentShowController::class)->name('students.show');
    Route::get('/students/{student}/edit', StudentEditController::class)->name('students.edit');
    Route::put('/students/{student}', StudentUpdateController::class)->name('students.update');
    Route::delete('/students/{student}', StudentDestroyController::class)->name('students.destroy');

    Route::delete('/enrollments/{enrollment}', EnrollmentDestroyController::class)->name('enrollments.destroy');

    Route::get('/users', UserIndexController::class)->name('users.index');
    Route::get('/users/create', UserCreateController::class)->name('users.create');
    Route::post('/users', UserStoreController::class)->name('users.store');
    Route::get('/users/{user}', UserShowController::class)->name('users.show');
    Route::get('/users/{user}/edit', UserEditController::class)->name('users.edit');
    Route::put('/users/{user}', UserUpdateController::class)->name('users.update');
    Route::delete('/users/{user}', UserDestroyController::class)->name('users.destroy');
});

Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/classrooms', \App\Http\Controllers\Teacher\TeacherClassroomIndexController::class)->name('classrooms.index');
    Route::get('/classrooms/{classroom}/attendance', \App\Http\Controllers\Teacher\AttendanceSessionIndexController::class)->name('classrooms.attendance.index');
    Route::get('/classrooms/{classroom}/attendance/create', \App\Http\Controllers\Teacher\AttendanceSessionCreateController::class)->name('classrooms.attendance.create');
    Route::post('/classrooms/{classroom}/attendance', \App\Http\Controllers\Teacher\AttendanceSessionStoreController::class)->name('classrooms.attendance.store');
    Route::get('/classrooms/{classroom}/attendance/{session}', \App\Http\Controllers\Teacher\AttendanceSessionShowController::class)->name('classrooms.attendance.edit');
    Route::put('/classrooms/{classroom}/attendance/{session}', \App\Http\Controllers\Teacher\AttendanceSessionUpdateController::class)->name('classrooms.attendance.update');
});

require __DIR__.'/auth.php';
