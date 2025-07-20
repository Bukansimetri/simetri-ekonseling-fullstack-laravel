<x-layout>
    <div class="main-content">
        <div class="content-area">
            <div class="page-header">
                <h2>Appointment Saya</h2>
                @if(auth()->user()->role === 'student' && !$appointments->isEmpty())
                <a href="{{ route('counselors.index') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i> Buat Appointment Baru
                </a>
                @endif
            </div>

            <div class="appointment-list">
                @if($appointments->isEmpty())
                    <div class="empty-appointment">
                        <div class="empty-container">
                            <div class="empty-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                    <path d="M9 16l2 2 4-4"></path>
                                </svg>
                            </div>
                            <h3 class="empty-title">Belum Ada Appointment</h3>
                            <p class="empty-description">Anda belum memiliki jadwal konseling. Temukan konselor profesional untuk memulai perjalanan kesehatan mental Anda.</p>
                            <a href="{{ route('counselors.index') }}" class="empty-button">
                                <i class="fas fa-search mr-2"></i> Cari Konselor
                            </a>
                        </div>
                    </div>
                @else
                    <div class="appointment-grid">
                        @foreach($appointments as $appointment)
                        <div class="appointment-card card-shadow {{ $appointment->status }}">
                            <div class="appointment-header">
                                <div class="status-badge badge-{{ $appointment->status }}">
                                    {{ ucfirst($appointment->status) }}
                                </div>
                                @if($appointment->type === 'group')
                                <div class="group-indicator">
                                    <i class="fas fa-users"></i> Group
                                </div>
                                @endif
                                <div class="appointment-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ Carbon\Carbon::parse($appointment->scheduled_at)->isoFormat('dddd, D MMMM YYYY') }}
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-clock"></i>
                                        {{ Carbon\Carbon::parse($appointment->scheduled_at)->format('H:i') }}
                                    </span>
                                </div>
                            </div>

                            <div class="appointment-profile">
                                @if(auth()->user()->role === 'student')
                                <div class="profile-info">
                                    <div class="profile-details">
                                        <h4>{{ $appointment->counselor->user->name }}</h4>
                                        <span class="specialty">{{ $appointment->counselor->specialization }}</span>
                                    </div>
                                </div>
                                @else
                                <div class="profile-info">
                                    <div class="profile-details">
                                        <h4>{{ $appointment->student->user->name }}</h4>
                                        <span class="university">{{ $appointment->student->university }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Tampilkan peserta untuk group appointment -->
                            @if($appointment->type === 'group')
                            <div class="group-participants">
                                <div class="detail-group">
                                    <label>Peserta Group:</label>
                                    <ul class="participant-list">
                                        <li class="participant-item">
                                            <span>{{ $appointment->student->user->name }}</span>
                                            <span class="participant-role">(Pembuat)</span>
                                        </li>
                                        @foreach($appointment->students as $student)
                                            @if($student->id != $appointment->student_id)
                                            <li class="participant-item">
                                                <span>{{ $student->user->name }}</span>
                                                @if(auth()->user()->id == $appointment->student->user_id || auth()->user()->role == 'counselor')
                                                <button class="btn-remove-participant"
                                                        data-appointment="{{ $appointment->id }}"
                                                        data-student="{{ $student->id }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                @endif
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>

                                @if(auth()->user()->id == $appointment->student->user_id && $appointment->status == 'pending')
                                <div class="detail-group add-participant-form">
                                    <label>Tambah Peserta:</label>
                                    <select class="add-participant-select"
                                            data-appointment="{{ $appointment->id }}">
                                        <option value="">Pilih peserta...</option>
                                        @foreach($otherStudents as $student)
                                            @if(!$appointment->students->contains($student->id))
                                            <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>
                            @endif

                            <div class="appointment-details">
                                <div class="detail-group">
                                    <label>Link Meeting:</label>
                                    @if($appointment->link_meeting)
                                    <a href="{{ $appointment->link_meeting }}" target="_blank" class="text-link">
                                        {{ Str::limit($appointment->link_meeting, 30) }}
                                    </a>
                                    @else
                                    <span class="text-muted">Belum tersedia</span>
                                    @endif
                                </div>
                                <div class="detail-group">
                                    <label>Catatan:</label>
                                    <p class="appointment-notes">{{ $appointment->notes ?? 'Tidak ada catatan' }}</p>
                                </div>
                            </div>

                            <div class="appointment-actions">
                                @if($appointment->status === 'pending' && auth()->user()->role === 'counselor')
                                    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="action-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check mr-2"></i> Konfirmasi
                                        </button>
                                    </form>
                                    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="action-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-outline">
                                            <i class="fas fa-times mr-2"></i> Tolak
                                        </button>
                                    </form>
                                @endif

                                @if($appointment->status === 'confirmed')
                                    <a href="{{ route('consultation.start', $appointment->id) }}" class="btn btn-primary">
                                        <i class="fas fa-video mr-2"></i> Mulai Konseling
                                    </a>
                                @endif

                                @if($appointment->status === 'pending' && auth()->user()->role === 'student')
                                    <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="action-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline">
                                            <i class="fas fa-trash-alt mr-2"></i> Batalkan
                                        </button>
                                    </form>
                                @endif

                                @if($appointment->status === 'completed' && auth()->user()->role === 'student')
                                    <a href="{{ route('feedback.create', $appointment->id) }}" class="btn btn-outline">
                                        <i class="fas fa-star mr-2"></i> Beri Ulasan
                                    </a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Tambahan style untuk group appointment */
        .group-indicator {
            display: inline-flex;
            align-items: center;
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-right: 8px;
        }

        .group-indicator i {
            margin-right: 4px;
            font-size: 10px;
        }

        .group-participants {
            margin: 10px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 6px;
        }

        .participant-list {
            list-style: none;
            padding: 0;
            margin: 5px 0 0 0;
        }

        .participant-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .participant-role {
            color: #666;
            font-size: 0.8em;
            margin-left: 5px;
        }

        .btn-remove-participant {
            background: none;
            border: none;
            color: #f44336;
            cursor: pointer;
            padding: 0 5px;
            font-size: 12px;
        }

        .add-participant-form select {
            width: 100%;
            padding: 6px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 5px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle add participant
            document.querySelectorAll('.add-participant-select').forEach(select => {
                select.addEventListener('change', function() {
                    const appointmentId = this.dataset.appointment;
                    const studentId = this.value;

                    if (!studentId) return;

                    fetch(`/appointments/${appointmentId}/add-students`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            student_ids: [studentId]
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message || 'Gagal menambahkan peserta');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan');
                    });

                    // Reset select
                    this.value = '';
                });
            });

            // Handle remove participant
            document.querySelectorAll('.btn-remove-participant').forEach(button => {
                button.addEventListener('click', function() {
                    if (!confirm('Apakah Anda yakin ingin menghapus peserta ini?')) return;

                    const appointmentId = this.dataset.appointment;
                    const studentId = this.dataset.student;

                    fetch(`/appointments/${appointmentId}/remove-student/${studentId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message || 'Gagal menghapus peserta');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan');
                    });
                });
            });
        });
    </script>
</x-layout>
