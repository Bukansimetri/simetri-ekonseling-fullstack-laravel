<x-layout>
    <div class="register-container">
        <div class="register-left">
            <h1>Bergabung dengan {{ $title ?? config('app.name') }}</h1>
            <p>Daftar sekarang untuk mendapatkan akses ke layanan konseling online profesional.</p>

            <div class="register-features">
                @foreach ($service as $itemservice)
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div>
                            <h4>{{ $itemservice->title }}</h4>
                            <p>{{ $itemservice->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="register-right">
            <div class="register-form-container">
                <div class="register-logo">
                    <img src="https://placehold.co/50x50/1a73e8/FFFFFF?text=MC" alt="MindCare Logo">
                    <h2>{{ $title ?? config('app.name') }}</h2>
                </div>

                <div class="register-form">
                    <div class="form-title">
                        <h3>Buat Akun Baru</h3>
                        <p>Isi formulir berikut untuk mendaftar</p>
                    </div>

                    <form id="registerForm" method="POST" action="{{ route('register.student') }}">
                        @csrf
                        <input type="hidden" name="role" value="student">
                        <div class="name-fields">
                            <div class="form-group">
                                <label for="firstName">Nama Lengkap</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Nama lengkap" required>
                                <div class="error-message">Nama lengkap harus diisi</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Alamat Email</label>
                            <div class="input-with-icon">
                                <input type="email" id="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                            </div>
                            <div class="error-message">Email tidak valid</div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <div class="input-with-icon">
                                <input type="tel" id="phone" name="phone" class="form-control" placeholder="0812-3456-7890">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Kata Sandi</label>
                            <div class="input-with-icon">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                                <i class="fas fa-eye password-toggle" style="text-align: right" id="togglePassword"></i>
                            </div>
                            <div class="error-message">Kata sandi minimal 8 karakter</div>
                        </div>

                        <div class="form-group">
                            <label for="confirmPassword">Konfirmasi Kata Sandi</label>
                            <div class="input-with-icon">
                                <input type="password" id="confirmPassword" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required>
                            </div>
                            <div class="error-message">Kata sandi tidak cocok</div>
                        </div>

                        <button type="submit" class="btn-register">Daftar Sekarang</button>
                    </form>

                    <div class="login-link">
                        Sudah punya akun? <a href="login.html">Masuk di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const registerForm = document.getElementById('registerForm');
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirmPassword');

            // Toggle password visibility
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                confirmPassword.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</x-layout>
