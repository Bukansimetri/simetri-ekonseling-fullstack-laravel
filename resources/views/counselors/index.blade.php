@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
<x-layout>
    <div class="main-content">
        <!-- Sidebar Filters -->
        <form method="GET" action="{{ route('counselors.index') }}" class="sidebar">
            <!-- Filter content ... -->
            <div class="filter-card">
                <h3>Filter <button type="submit" class="reset-btn">Reset</button></h3>

                <div class="filter-group">
                    <h4>Ketersediaan</h4>
                    <ul class="filter-options">
                        <li><label><input type="checkbox" name="availability[]" value="available_now" {{ in_array('available_now', request('availability', [])) ? 'checked' : '' }}> Tersedia Sekarang</label></li>
                    </ul>
                </div>

                <button type="submit" class="btn btn-primary w-full mt-4">Terapkan Filter</button>
            </div>
        </form>

        <!-- Counselor List -->
        <div class="content-area">
            <div class="page-header">
                <h2>Daftar Konselor</h2>
                <div class="sort-options">
                    <select>
                        <option>Urutkan berdasarkan: Rating Tertinggi</option>
                        <option>Harga Terendah</option>
                        <option>Harga Tertinggi</option>
                        <option>Jadwal Terdekat</option>
                    </select>
                </div>
            </div>

            <div class="counselor-list">
                @foreach ($counselors as $counselor)
                <div class="counselor-card">
                    <div class="counselor-image" style="background-image: url('{{ asset('storage/'.$counselor->image) }}');"></div>
                    <div class="counselor-info">
                        <h3>{{ $counselor->name }}</h3>
                        <span class="counselor-specialty">{{ $counselor->education }}</span>
                        <p class="counselor-bio">
                            {{ Str::limit($counselor->essay, 150, '...') }}
                        </p>
                        <div class="counselor-meta">
                            <span><i class="fas fa-clock"></i> {{ $counselor->is_active ? 'Tersedia Sekarang' : 'Tidak Tersedia' }}</span>
                        </div>
                        <div class="counselor-actions">
                            <button class="btn-small open-appointment-modal" data-id="{{ $counselor->id }}" data-name="{{ $counselor->name }}">Buat Janji</button>
                            <button class="btn-outline-small open-profile-modal" data-id="{{ $counselor->id }}">Profil</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if ($counselors->lastPage() > 1)
                <div class="pagination">
                    {{-- Tombol Previous --}}
                    @if ($counselors->currentPage() > 1)
                        <a href="{{ $counselors->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
                    @endif

                    {{-- Tautan Halaman (Maksimal 5) --}}
                    @php
                        $start = max(1, $counselors->currentPage() - 2);
                        $end = min($counselors->lastPage(), $start + 4);
                        $start = max(1, $end - 4);
                    @endphp

                    @for ($i = $start; $i <= $end; $i++)
                        <a href="{{ $counselors->url($i) }}" class="{{ ($counselors->currentPage() == $i) ? 'active' : '' }}">{{ $i }}</a>
                    @endfor

                    {{-- Tombol Next --}}
                    @if ($counselors->currentPage() < $counselors->lastPage())
                        <a href="{{ $counselors->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Modern Appointment Modal -->
        <div id="appointmentModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Buat Janji Konseling</h3>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="counselor-info" style="display: flex; align-items: center; margin-bottom: 20px;">
                        <div class="profile-image-small" style="width: 50px; height: 50px; border-radius: 50%; background-size: cover; background-image: url('http://127.0.0.1:8003/storage/counselors/default.jpg'); margin-right: 15px;"></div>
                        <div>
                            <h4 id="modalCounselorName" style="margin: 0 0 5px 0; font-size: 1.2rem;"></h4>
                        </div>
                    </div>

                    <form id="appointmentForm">
                        <input type="hidden" id="counselorId" name="counselor_id">

                        <div class="form-group">
                            <label for="appointmentDate">Tanggal Konseling</label>
                            <input type="date" id="appointmentDate" name="date" required min="">
                        </div>

                        <div class="form-group">
                            <label for="appointmentTime">Pilih Jam Konseling</label>
                            <select id="appointmentTime" name="time" required>
                                <option value="">-- Pilih Waktu --</option>
                                @for ($hour = 7; $hour < 23; $hour++)
                                    @php
                                        $start = sprintf('%02d:00', $hour);
                                        $end = sprintf('%02d:00', $hour + 1);
                                    @endphp
                                    <option value="{{ $start }}">{{ $start }} - {{ $end }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="appointmentNotes">Note (Opsional)</label>
                            <textarea id="appointmentNotes" name="notes" placeholder="Tulis Note Konseling"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline close-modal">Batal</button>
                    <button class="btn btn-primary" id="submitAppointment">Buat Janji</button>
                </div>
            </div>
        </div>

        <!-- Modern Profile Modal -->
        <div id="profileModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Profil Konselor</h3>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="profile-header">
                        <div class="profile-image" style="background-image: url('http://127.0.0.1:8003/storage/counselors/default.jpg');"></div>
                        <div class="profile-info">
                            <h4 id="profileName"></h4>
                            <div class="profile-meta">
                                <span><i class="fas fa-clock"></i> <span id="profileAvailability"></span></span>
                            </div>
                        </div>
                    </div>

                    <div class="profile-details">
                        <h5>Tentang Saya</h5>
                        <p id="profileBio"></p>

                        <h5>Riwayat Pendidikan</h5>
                        <ul id="profileEducationList" style="padding-left: 20px; color: #555;">
                            <li>S1 Psikologi - Universitas Indonesia (2010-2014)</li>
                            <li>Professional Counselor Certification (2015)</li>
                            <li>Pelatihan Terapi Kognitif Perilaku (2016)</li>
                        </ul>

                        <h5>Pengalaman Kerja</h5>
                        <ul id="profileExperienceList" style="padding-left: 20px; color: #555;">
                            <li>Konselor di RS Jiwa Jakarta (2015-2018)</li>
                            <li>Konselor Remaja di Sekolah ABC (2018-sekarang)</li>
                            <li>Pembicara di berbagai seminar kesehatan mental</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal functionality
            const appointmentModal = document.getElementById('appointmentModal');
            const profileModal = document.getElementById('profileModal');
            const closeButtons = document.querySelectorAll('.close, .close-modal');

            // Set minimum date to today for appointment date
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('appointmentDate').min = today;

            let counselors = {};

            fetch('/api/counselors')
                .then(response => response.json())
                .then(data => {
                    counselors = data;
                    console.log('All Counselors Loaded:', counselors);
                })
                .catch(err => console.error('Gagal load counselors:', err));

            // Open Appointment Modal
            document.querySelectorAll('.open-appointment-modal').forEach(button => {
                button.addEventListener('click', function() {
                    const counselorId = this.getAttribute('data-id');
                    const counselorName = this.getAttribute('data-name');

                    document.getElementById('modalCounselorName').textContent = counselorName;
                    document.getElementById('counselorId').value = counselorId;

                    // Reset form
                    document.getElementById('appointmentForm').reset();

                    // Show modal with animation
                    appointmentModal.style.display = 'block';
                    setTimeout(() => {
                        appointmentModal.classList.add('show');
                    }, 10);
                });
            });

            // Open Profile Modal
            document.querySelectorAll('.open-profile-modal').forEach(button => {
                button.addEventListener('click', function() {
                    const counselorId = this.getAttribute('data-id');
                    const counselor = counselors[counselorId];

                    if (!counselor) return;

                    // Set profile data
                    document.getElementById('profileName').textContent = counselor.name;
                    document.getElementById('profileBio').textContent = counselor.bio;

                    document.getElementById('profileAvailability').textContent = counselor.availability;

                    // Set education list
                    const educationList = document.getElementById('profileEducationList');
                    educationList.innerHTML = '';
                    counselor.education.forEach(edu => {
                        const li = document.createElement('li');
                        li.textContent = edu;
                        educationList.appendChild(li);
                    });

                    // Set experience list
                    const experienceList = document.getElementById('profileExperienceList');
                    experienceList.innerHTML = '';
                    counselor.experience.forEach(exp => {
                        const li = document.createElement('li');
                        li.textContent = exp;
                        experienceList.appendChild(li);
                    });

                    // Show modal with animation
                    profileModal.style.display = 'block';
                    setTimeout(() => {
                        profileModal.classList.add('show');
                    }, 10);
                });
            });

            // Close Modals
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const modal = this.closest('.modal');
                    modal.classList.remove('show');
                    setTimeout(() => {
                        modal.style.display = 'none';
                    }, 300);
                });
            });

            // Close when clicking outside modal
            window.addEventListener('click', function(event) {
                if (event.target === appointmentModal) {
                    appointmentModal.classList.remove('show');
                    setTimeout(() => {
                        appointmentModal.style.display = 'none';
                    }, 300);
                }
                if (event.target === profileModal) {
                    profileModal.classList.remove('show');
                    setTimeout(() => {
                        profileModal.style.display = 'none';
                    }, 300);
                }
            });

            // Submit Appointment Form
            document.getElementById('submitAppointment').addEventListener('click', function () {
                const modal = document.getElementById('appointmentModal');
                const date = modal.querySelector('#appointmentDate').value;
                const time = modal.querySelector('#appointmentTime').value;
                const notes = modal.querySelector('#appointmentNotes').value;
                const counselorId = modal.querySelector('#counselorId').value;

                if (!date || !time) {
                    alert('Harap lengkapi semua field yang wajib diisi!');
                    return;
                }

                const scheduledAt = `${date} ${time}:00`;

                fetch('/appointments/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        counselor_id: counselorId,
                        scheduled_at: scheduledAt,
                        notes: notes,
                        status: 'Open'
                    })
                })
                .then(response => {
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        throw new Error('Server returned HTML instead of JSON');
                    }
                })
                .then(data => {
                    alert(data.message);
                    modal.style.display = 'none';
                })
                .catch(error => {
                    console.error('Fetch Error Detail:', error);
                    if (error.errors) {
                        let messages = Object.values(error.errors).flat().join('\n');
                        alert(`Gagal membuat janji:\n${messages}`);
                    } else {
                        alert('Terjadi kesalahan saat mengirim data.\n' + error.message);
                    }
                });
            });



            // Counselor rating hover effect
            const counselorCards = document.querySelectorAll('.counselor-card');
            counselorCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    const rating = this.querySelector('.counselor-rating');
                    if (rating) {
                        rating.style.color = '#ff9800';
                    }
                });

                card.addEventListener('mouseleave', function() {
                    const rating = this.querySelector('.counselor-rating');
                    if (rating) {
                        rating.style.color = '#ffc107';
                    }
                });
            });
        });
    </script>
</x-layout>
