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
</x-layout>
