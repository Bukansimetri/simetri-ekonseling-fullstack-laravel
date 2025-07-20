<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index'])->name('homepage');

// Student Register
Route::get('/register/student', [CustomRegisterController::class, 'showStudentForm'])->name('register.student.form');
Route::post('/register/student', [CustomRegisterController::class, 'registerStudent'])->name('register.student');

// Counselor Register
Route::get('/register/counselor', [CustomRegisterController::class, 'showCounselorForm'])->name('register.counselor.form');
Route::post('/register/counselor', [CustomRegisterController::class, 'registerCounselor'])->name('register.counselor');

// Login
Route::get('/login', [CustomLoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [CustomLoginController::class, 'login'])->name('login');

// Logout
Route::post('/logout', [CustomLoginController::class, 'logout'])->name('logout');

Route::get('/counselors', [CounselorController::class, 'index'])->name('counselors.index');
Route::get('/counselors/{id}', [CounselorController::class, 'show'])->name('counselors.show');

Route::get('/counselors/{id}/profile', [CounselorController::class, 'ajaxShow'])->name('counselors.ajaxShow');
Route::get('/api/counselors', [CounselorController::class, 'apiIndex']);

// Halaman profil
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->role === 'student') {
            return view('dashboard.student', compact('user'));
        } elseif ($user->role === 'counselor') {
            return view('dashboard.counselor', compact('user'));
        } else {
            abort(403, 'Unauthorized');
        }
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Appointment Routes
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::post('/appointments/group', [AppointmentController::class, 'storeGroup']);
    Route::post('/appointments/{appointment}/add-students', [AppointmentController::class, 'addStudentToGroup']);
    Route::delete('/appointments/{appointment}/remove-student/{student}', [AppointmentController::class, 'removeStudentFromGroup']);

});
