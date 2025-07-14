<x-layout>
    <div class="login-container">
        <div class="login-left">
            <h1>Selamat Datang Kembali</h1>
            <p>Masuk ke akun {{ $title ?? config('app.name') }} anda dan lanjutkan konseling</p>

            <div class="login-features">
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

        <div class="login-right">
            <div class="login-form-container">
                <div class="login-logo">
                    <img src="https://placehold.co/50x50/1a73e8/FFFFFF?text=MC" alt="MindCare Logo">
                    <h2>{{ $title ?? config('app.name') }}</h2>
                </div>

                <div class="login-form">
                    <div class="form-title">
                        <h3>Masuk ke Akun Anda</h3>
                        <p>Silakan masukkan email dan kata sandi Anda</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group {{ $errors->has('email') ? 'error' : '' }}">
                            <label for="email">Alamat Email</label>
                            <div class="input-with-icon">
                                <input type="email" id="email" name="email" class="form-control" placeholder="email@contoh.com" value="{{ old('email') }}" required autofocus>
                            </div>
                            @if ($errors->has('email'))
                                <div class="error-message">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('password') ? 'error' : '' }}">
                            <label for="password">Kata Sandi</label>
                            <div class="input-with-icon">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required>
                            </div>
                            @if ($errors->has('password'))
                                <div class="error-message">{{ $errors->first('password') }}</div>
                            @endif
                        </div>

                        <div class="remember-forgot">
                            <div class="remember-me">
                                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">Ingat saya</label>
                            </div>
                            <a href="#" class="forgot-password">Lupa kata sandi?</a>
                        </div>

                        <button type="submit" class="btn-login">Masuk</button>
                    </form>

                    <div class="register-link">
                        Belum punya akun? <a href="{{ route('register.student') }}">Daftar sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
