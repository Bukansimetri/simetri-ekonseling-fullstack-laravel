<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user->role === 'student') {
            $user->load('student');
        } elseif ($user->role === 'counselor') {
            $user->load('counselor');
        }

        return view('profile.show', [
            'user' => $user,
            'title' => 'Profil Saya',
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'current_password' => 'nullable|string',
            'new_password' => ['nullable', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
            'new_password_confirmation' => 'nullable|same:new_password',
        ];

        // Tambahkan validasi berdasarkan role
        if ($user->role === 'student') {
            $rules = array_merge($rules, [
                'name' => 'required|string|max:255',
                'username' => 'nullable|string|max:20',
                'email' => 'required|string|email|max:255|unique:students,email,' . $user->student->id,
                'phone' => 'nullable|string|max:20',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'place_of_birth' => 'nullable|string|max:100',
                'date_of_birth' => 'nullable|string|max:100',
                'address' => 'nullable|string|max:100',
                'etnic' => 'nullable|string|max:100',
                'bio' => 'nullable|string|max:255',
                'hobby' => 'nullable|string|max:100',
            ]);
        } elseif ($user->role === 'counselor') {
            $rules = array_merge($rules, [
                'name' => 'required|string|max:255',
                'username' => 'nullable|string|max:20',
                'email' => 'required|string|email|max:255|unique:counselors,email,' . $user->counselor->id,
                'phone' => 'nullable|string|max:20',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'education' => 'nullable|string|max:100',
                'experience' => 'nullable|string',
                'address' => 'nullable|string',
                'essay' => 'nullable|string',
                'office' => 'nullable|string',
            ]);
        }

        $validated = $request->validate($rules);

        // Update password
        if (!empty($validated['current_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
            }

            $user->password = Hash::make($validated['new_password']);
            $user->save();
        }

        // Update berdasarkan role
        if ($user->role === 'student' && $user->student) {
            $student = $user->student;

            // Update foto jika ada
            if ($request->hasFile('image')) {
                if ($student->image && $student->image !== 'default.jpg') {
                    Storage::delete('public/' . $student->image);
                }

                $student->image = $request->file('image')->store('profile_images', 'public');
            }

            $student->update([
                'name' => $validated['name'],
                'username' => $validated['username'] ?? null,
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'place_of_birth' => $validated['place_of_birth'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'address' => $validated['address'] ?? null,
                'etnic' => $validated['etnic'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'hobby' => $validated['hobby'] ?? null,
            ]);
        } elseif ($user->role === 'counselor' && $user->counselor) {
            $counselor = $user->counselor;

            // Update foto jika ada
            if ($request->hasFile('image')) {
                if ($counselor->image && $counselor->image !== 'default.jpg') {
                    Storage::delete('public/' . $counselor->image);
                }

                $counselor->image = $request->file('image')->store('profile_images', 'public');
            }

            $counselor->update([
                'name' => $validated['name'],
                'username' => $validated['username'] ?? null,
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'education' => $validated['education'] ?? null,
                'experience' => $validated['experience'] ?? null,
                'address' => $validated['address'] ?? null,
                'essay' => $validated['essay'] ?? null,
                'office' => $validated['office'] ?? null,
            ]);
        }

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui');
    }
}
