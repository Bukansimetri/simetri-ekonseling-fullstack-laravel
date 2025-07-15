<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    // Menampilkan daftar appointment
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'student') {
            $user->load('student');
            $appointments = Appointment::where('student_id', $user->student->id)
                ->with('counselor.user')
                ->latest()
                ->get();
        } elseif ($user->role === 'counselor') {
            $user->load('counselor');
            $appointments = Appointment::where('counselor_id', $user->counselor->id)
                ->with('student.user')
                ->latest()
                ->get();
        } else {
            $appointments = collect();
        }

        return view('appointments.index', [
            'appointments' => $appointments,
            'title' => 'Appointment Saya',
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validasi request
            $request->validate([
                'counselor_id' => 'required|exists:counselors,id',
                'scheduled_at' => 'required|date',
                'notes' => 'nullable|string',
            ]);

            // Ambil student_id dari user login
            $user = Auth::user();
            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login sebagai student untuk membuat janji.',
                ], 401);
            }

            $appointment = new Appointment;
            $appointment->student_id = $user->student->id;
            $appointment->counselor_id = $request->counselor_id;
            $appointment->scheduled_at = $request->scheduled_at;
            $appointment->status = 'pending';
            $appointment->notes = $request->notes ?? '';
            $appointment->save();

            return response()->json([
                'success' => true,
                'message' => 'Janji berhasil dibuat!',
            ]);
        } catch (\Exception $e) {
            Log::error('Appointment Store Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan di server: '.$e->getMessage(),
            ], 500);
        }
    }

    // Update status appointment (confirm/reject)
    public function update(Request $request, Appointment $appointment)
    {
        $user = Auth::user();
        $status = $request->input('status');

        // Validasi bahwa hanya counselor yang bisa update status
        if ($user->role !== 'counselor' || $appointment->counselor_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi status yang diperbolehkan
        if (! in_array($status, ['confirmed', 'rejected'])) {
            abort(400, 'Invalid status');
        }

        // Validasi bahwa hanya appointment pending yang bisa diupdate
        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Hanya appointment dengan status pending yang bisa diubah');
        }

        $appointment->update(['status' => $status]);

        $message = $status === 'confirmed'
            ? 'Appointment telah dikonfirmasi'
            : 'Appointment telah ditolak';

        return back()->with('success', $message);
    }

    // Membatalkan appointment (student)
    public function destroy(Appointment $appointment)
    {
        $user = Auth::user();

        // Validasi bahwa hanya student pemilik appointment yang bisa membatalkan
        if ($user->role !== 'student' || $appointment->student_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi bahwa hanya appointment pending yang bisa dibatalkan
        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Hanya appointment dengan status pending yang bisa dibatalkan');
        }

        $appointment->delete();

        return back()->with('success', 'Appointment berhasil dibatalkan');
    }
}
