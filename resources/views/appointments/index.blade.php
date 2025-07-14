<x-layout>
    <div class="main-content">
        <div class="content-area">
            <div class="page-header">
                <h2>Appointment Saya</h2>
            </div>

            <div class="appointment-list">
                @if($appointments->isEmpty())
                    <div class="empty-appointment">
                        <div class="empty-container">
                            <div class="empty-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
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
                                <i class="fas fa-search"></i> Cari Konselor
                            </a>
                        </div>
                    </div>
                @else
                    @foreach($appointments as $appointment)
                    <div class="appointment-card {{ $appointment->status }}">
                        <div class="appointment-header">
                            <div class="appointment-meta">
                                <span class="status-badge">{{ ucfirst($appointment->status) }}</span>
                                <span class="appointment-date"><i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($appointment->scheduled_at)->format('d M Y') }}</span>
                                <span class="appointment-time"><i class="fas fa-clock"></i> {{ Carbon\Carbon::parse($appointment->scheduled_at)->format('H:i') }}</span>
                            </div>
                            @if(auth()->user()->role === 'student')
                            <div class="counselor-info">
                                <img src="{{ asset('storage/'.$appointment->counselor->user->image) }}" alt="{{ $appointment->counselor->user->name }}">
                                <div>
                                    <h4>{{ $appointment->counselor->user->name }}</h4>
                                    <span class="specialty">{{ $appointment->counselor->specialization }}</span>
                                </div>
                            </div>
                            @else
                            <div class="student-info">
                                <img src="{{ asset('storage/'.$appointment->student->user->image) }}" alt="{{ $appointment->student->user->name }}">
                                <div>
                                    <h4>{{ $appointment->student->user->name }}</h4>
                                    <span class="university">{{ $appointment->student->university }}</span>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="appointment-details">
                            <div class="detail-group">
                                <label>Waktu Konseling:</label>
                                <span>{{ Carbon\Carbon::parse($appointment->scheduled_at)->format('d M Y H:i') }}</span>
                            </div>
                            <div class="detail-group">
                                <label>Catatan:</label>
                                <p>{{ $appointment->notes ?? 'Tidak ada catatan' }}</p>
                            </div>
                        </div>

                        <div class="appointment-actions">
                            @if($appointment->status === 'pending' && auth()->user()->role === 'counselor')
                                <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                </form>
                                <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-outline">Tolak</button>
                                </form>
                            @endif

                            @if($appointment->status === 'confirmed')
                                <a href="{{ route('consultation.start', $appointment->id) }}" class="btn btn-primary">Mulai Konseling</a>
                            @endif

                            @if($appointment->status === 'pending' && auth()->user()->role === 'student')
                                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline">Batalkan</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-layout>
