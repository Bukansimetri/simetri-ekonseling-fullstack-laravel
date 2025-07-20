<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    // Method untuk membuat appointment individual
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'counselor_id' => 'required|exists:counselors,id',
            'scheduled_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $appointment = Appointment::create([
            'student_id' => $request->student_id,
            'counselor_id' => $request->counselor_id,
            'scheduled_at' => $request->scheduled_at,
            'status' => 'scheduled',
            'notes' => $request->notes,
            'type' => 'individual',
        ]);

        return response()->json($appointment, 201);
    }

    // Method untuk membuat group appointment
    public function storeGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id', // student utama/pembuat
            'counselor_id' => 'required|exists:counselors,id',
            'scheduled_at' => 'required|date',
            'notes' => 'nullable|string',
            'additional_students' => 'required|array',
            'additional_students.*' => 'exists:students,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Buat appointment
        $appointment = Appointment::create([
            'student_id' => $request->student_id, // student utama
            'counselor_id' => $request->counselor_id,
            'scheduled_at' => $request->scheduled_at,
            'status' => 'scheduled',
            'notes' => $request->notes,
            'type' => 'group',
        ]);

        // Attach students tambahan
        $appointment->students()->attach($request->additional_students);
        // Attach student utama juga ke pivot table
        $appointment->students()->attach($request->student_id);

        return response()->json([
            'appointment' => $appointment,
            'participants' => $appointment->students,
        ], 201);
    }

    // Method untuk menambahkan student ke group appointment
    public function addStudentToGroup(Request $request, $appointmentId)
    {
        $validator = Validator::make($request->all(), [
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $appointment = Appointment::findOrFail($appointmentId);

        // Pastikan ini adalah group appointment
        if ($appointment->type !== 'group') {
            return response()->json(['message' => 'Hanya group appointment yang bisa menambahkan peserta'], 400);
        }

        // Tambahkan students
        $appointment->students()->syncWithoutDetaching($request->student_ids);

        return response()->json([
            'message' => 'Students added successfully',
            'participants' => $appointment->students,
        ]);
    }

    // Method untuk menghapus student dari group appointment
    public function removeStudentFromGroup(Request $request, $appointmentId, $studentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        // Pastikan ini adalah group appointment
        if ($appointment->type !== 'group') {
            return response()->json(['message' => 'Hanya group appointment yang bisa menghapus peserta'], 400);
        }

        // Pastikan student utama tidak dihapus
        if ($appointment->student_id == $studentId) {
            return response()->json(['message' => 'Tidak bisa menghapus student utama dari appointment'], 400);
        }

        $appointment->students()->detach($studentId);

        return response()->json(['message' => 'Student removed successfully']);
    }

    // Method untuk menampilkan detail appointment dengan participants
    public function show($id)
    {
        $appointment = Appointment::with(['students', 'mainStudent', 'counselor'])->findOrFail($id);

        return response()->json([
            'appointment' => $appointment,
            'main_student' => $appointment->mainStudent,
            'participants' => $appointment->students,
            'counselor' => $appointment->counselor,
        ]);
    }
}
