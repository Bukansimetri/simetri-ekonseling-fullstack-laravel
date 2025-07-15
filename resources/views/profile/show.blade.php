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
                                <img src="{{ asset('storage/' . ($user->student?->image ?? $user->counselor?->image ?? 'default.jpg')) }}" id="avatarPreview" alt="Profile Picture">
                            </div>
                            <input type="file" id="avatarInput" name="image" accept="image/*" style="display: none;">
                            <button type="button" class="btn btn-outline" onclick="document.getElementById('avatarInput').click()">Ubah Foto</button>
                        </div>

                        <div class="profile-info">
                            <h3>{{ $user->student?->name ?? $user->counselor?->name }}</h3>
                            <p class="role-badge">{{ ucfirst($user->role) }}</p>
                        </div>
                    </div>

                    <div class="profile-form">
                        <div class="form-section">
                            <h4>Informasi Dasar</h4>

                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $user->student?->name ?? $user->counselor?->name) }}" required>
                                @error('name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email', $user->student?->email ?? $user->counselor?->email) }}" required>
                                @error('email')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">Nomor Telepon</label>
                                <input type="tel" id="phone" name="phone"
                                    value="{{ old('phone', $user->student?->phone ?? $user->counselor?->phone) }}">
                                @error('phone')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @if($user->role === 'student' && $user->student)
                        <div class="form-section">
                            <h4>Informasi Mahasiswa</h4>

                            <div class="form-group">
                                <label for="username">NIM</label>
                                <input type="text" id="username" name="username"
                                    value="{{ old('username', $user->student->username) }}">
                                @error('username')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="place_of_birth">Tempat Lahir</label>
                                <input type="text" id="place_of_birth" name="place_of_birth"
                                    value="{{ old('place_of_birth', $user->student->place_of_birth) }}">
                                @error('place_of_birth')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="date_of_birth">Tanggal Lahir</label>
                                <input type="date" id="date_of_birth" name="date_of_birth"
                                    value="{{ old('date_of_birth', $user->student->date_of_birth) }}">
                                @error('date_of_birth')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <textarea id="address" name="address">{{ old('address', $user->student->address) }}</textarea>
                                @error('address')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="hobby">Hobby</label>
                                <input type="text" id="hobby" name="hobby"
                                    value="{{ old('hobby', $user->student->hobby) }}">
                                @error('hobby')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="bio">Bio</label>
                                <textarea id="bio" name="bio">{{ old('bio', $user->student->bio) }}</textarea>
                                @error('bio')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if($user->role === 'counselor' && $user->counselor)
                        <div class="form-section">
                            <h4>Informasi Konselor</h4>

                            <div class="form-group">
                                <label for="education">Pendidikan</label>
                                <input type="text" id="education" name="education"
                                    value="{{ old('education', $user->counselor->education) }}">
                                @error('education')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="experience">Pengalaman</label>
                                <textarea id="experience" name="experience">{{ old('experience', $user->counselor->experience) }}</textarea>
                                @error('experience')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <textarea id="address" name="address">{{ old('address', $user->counselor->address) }}</textarea>
                                @error('address')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="essay">Essay</label>
                                <textarea id="essay" name="essay">{{ old('essay', $user->counselor->essay) }}</textarea>
                                @error('essay')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="office">Tempat Praktik</label>
                                <input type="text" id="office" name="office"
                                    value="{{ old('office', $user->counselor->office) }}">
                                @error('office')
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
