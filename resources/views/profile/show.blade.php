<x-layout>
    <div class="main-content">
        <div class="content-area">
            <div class="page-header">
                <h2>Profil Saya</h2>
            </div>

            <div class="profile-container">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="profile-header">
                        <div class="avatar-upload">
                            <div class="avatar-preview">
                                {{-- <img src="{{ asset('storage/'.$user->student->image) }}" id="avatarPreview" alt="Profile Picture"> --}}
                                <img src="{{ asset('storage/'.($user->student->image ?? 'default.jpg')) }}" id="avatarPreview" alt="Profile Picture">
                            </div>
                            <input type="file" id="avatarInput" name="image" accept="image/*" style="display: none;">
                            <button type="button" class="btn btn-outline" onclick="document.getElementById('avatarInput').click()">Ubah Foto</button>
                        </div>

                        <div class="profile-info">
                            <h3>{{ $user->name }}</h3>
                            <p class="role-badge">{{ ucfirst($user->role) }}</p>
                        </div>
                    </div>

                    <div class="profile-form">
                        <div class="form-section">
                            <h4>Informasi Dasar</h4>

                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->student->name) }}" required>
                                @error('name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">Nomor Telepon</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @if($user->role === 'student' && $user->student)
                        <div class="form-section">
                            <h4>Informasi Mahasiswa</h4>

                            <div class="form-group">
                                <label for="student.username">NIM</label>
                                <input type="text" id="student.username" name="student[username]" value="{{ old('student.username', $user->student->username) }}">
                                @error('student.username')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="student.place_of_birth">Tempat Lahir</label>
                                <input type="text" id="student.place_of_birth" name="student[place_of_birth]" value="{{ old('student.place_of_birth', $user->student->university) }}">
                                @error('student.place_of_birth')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="student.date_of_birth">Tanggal Lahir</label>
                                <input type="text" id="student.date_of_birth" name="student[date_of_birth]" value="{{ old('student.date_of_birth', $user->student->university) }}">
                                @error('student.date_of_birth')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="student.address">Alamat</label>
                                <input type="textarea" id="student.address" name="student[address]" value="{{ old('student.address', $user->student->university) }}">
                                @error('student.address')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="student.hobby">Hobby</label>
                                <input type="text" id="student.hobby" name="student[hobby]" value="{{ old('student.hobby', $user->student->university) }}">
                                @error('student.hobby')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="student.bio">Bio</label>
                                <input type="textarea" id="student.bio" name="student[bio]" value="{{ old('student.bio', $user->student->university) }}">
                                @error('student.bio')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if($user->role === 'counselor' && $user->counselor)
                        <div class="form-section">
                            <h4>Informasi Konselor</h4>

                            <div class="form-group">
                                <label for="counselor.education">Education</label>
                                <input type="text" id="counselor.education" name="counselor[education]" value="{{ old('counselor.education', $user->counselor->education) }}">
                                @error('counselor.office')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="counselor.experience">Pengalaman</label>
                                <textarea id="counselor.experience" name="counselor[experience]">{{ old('counselor.experience', $user->counselor->experience) }}</textarea>
                                @error('counselor.experience')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="counselor.address">Address</label>
                                <textarea id="counselor.address" name="counselor[address]">{{ old('counselor.address', $user->counselor->address) }}</textarea>
                                @error('counselor.address')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="counselor.essay">Essay</label>
                                <textarea id="counselor.essay" name="counselor[essay]">{{ old('counselor.essay', $user->counselor->essay) }}</textarea>
                                @error('counselor.essay')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="counselor.office">Office</label>
                                <input type="text" id="counselor.office" name="counselor[office]" value="{{ old('counselor.office', $user->counselor->office) }}">
                                @error('counselor.office')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <div class="form-section">
                            <h4>Ubah Password</h4>
                            <p class="form-note">Biarkan kosong jika tidak ingin mengubah password</p>

                            <div class="form-group">
                                <label for="current_password">Password Saat Ini</label>
                                <input type="password" id="current_password" name="current_password">
                                @error('current_password')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" id="new_password" name="new_password">
                                @error('new_password')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation">
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('profile') }}" class="btn btn-outline">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preview avatar when selected
            const avatarInput = document.getElementById('avatarInput');
            const avatarPreview = document.getElementById('avatarPreview');

            avatarInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</x-layout>
