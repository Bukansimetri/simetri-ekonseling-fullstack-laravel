<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function show()
    {
        $user = Auth::user();

        // Load relasi berdasarkan role
        if ($user->role === 'student') {
            $user->load('student');
        } elseif ($user->role === 'counselor') {
            $user->load('counselor');
        }

        // dd($user->student);

        return view('profile.show', [
            'user' => $user,
            'title' => 'Profil Saya',
        ]);
    }

    // Memproses update profil
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi dasar untuk semua user
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|string',
            'new_password' => ['nullable', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
            'new_password_confirmation' => 'nullable|same:new_password',
        ];

        // Tambahkan validasi khusus berdasarkan role
        if ($user->role === 'student') {
            $rules = array_merge($rules, [
                'nim' => 'nullable|string|max:20',
                'university' => 'nullable|string|max:100',
                'faculty' => 'nullable|string|max:100',
                'study_program' => 'nullable|string|max:100',
            ]);
        } elseif ($user->role === 'counselor') {
            $rules = array_merge($rules, [
                'specialization' => 'nullable|string|max:100',
                'education' => 'nullable|string',
                'experience' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
            ]);
        }

        $validatedData = $request->validate($rules);

        // Update password jika diisi
        if (! empty($validatedData['current_password'])) {
            if (! Hash::check($validatedData['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
            }

            $user->password = Hash::make($validatedData['new_password']);
        }

        // Update foto profil jika diupload
        if ($request->hasFile('image')) {
            // Hapus foto lama jika bukan default
            if ($user->image !== 'default.jpg') {
                Storage::delete('public/'.$user->image);
            }

            $imagePath = $request->file('image')->store('profile_images', 'public');
            $user->image = $imagePath;
        }

        // Update data user utama
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'] ?? null;
        $user->save();

        // Update data relasi berdasarkan role
        if ($user->role === 'student' && $user->student) {
            $user->student->update([
                'nim' => $validatedData['nim'] ?? null,
                'university' => $validatedData['university'] ?? null,
                'faculty' => $validatedData['faculty'] ?? null,
                'study_program' => $validatedData['study_program'] ?? null,
            ]);
        } elseif ($user->role === 'counselor' && $user->counselor) {
            $user->counselor->update([
                'specialization' => $validatedData['specialization'] ?? null,
                'education' => $validatedData['education'] ?? null,
                'experience' => $validatedData['experience'] ?? null,
                'price' => $validatedData['price'] ?? null,
            ]);
        }

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui');
    }
}
