<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Counselor;
use App\Models\HeroSection;
use App\Models\Service;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomRegisterController extends Controller
{
    public function showStudentForm()
    {
        $herosection = HeroSection::where('is_active', 1)
            ->latest()
            ->limit(1)
            ->get();

        $service = Service::where('is_active', 1)
            ->latest()
            ->limit(3)
            ->get();

        return view('auth.register-student', compact('herosection', 'service'));
    }

    public function showCounselorForm()
    {
        $herosection = HeroSection::where('is_active', 1)
            ->latest()
            ->limit(1)
            ->get();

        $service = Service::where('is_active', 1)
            ->latest()
            ->limit(3)
            ->get();

        return view('auth.register-counselor', compact('herosection', 'service'));
    }

    public function registerStudent(Request $request)
    {
        Log::info('RegisterStudent dipanggil', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'student',
            'password' => Hash::make($request->password),
        ]);

        Log::info('User created:', $user->toArray());

        $student = Student::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $request->phone,
        ]);

        Log::info('User created:', $student->toArray());

        Auth::login($user);

        return redirect()->route('homepage');
    }

    public function registerCounselor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'counselor',
            'password' => Hash::make($request->password),
        ]);

        Counselor::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $request->phone,
        ]);

        Auth::login($user);

        return redirect()->route('homepage');
    }
}
