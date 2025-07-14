<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('meta')
    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <style>
        .user-profile {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            padding: 5px;
        }

        .dropdown-toggle img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-top: 8px;
            min-width: 160px;
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .dropdown-menu.show {
            display: block;
            opacity: 1;
            visibility: visible;
        }

        .dropdown-menu a, .dropdown-menu button {
            display: block;
            width: 100%;
            padding: 10px 15px;
            text-align: left;
            background: none;
            border: none;
            font-size: 14px;
            color: #333;
            text-decoration: none;
            cursor: pointer;
        }

        .dropdown-menu a:hover, .dropdown-menu button:hover {
            background-color: #f5f5f5;
        }

        .dropdown-divider {
            height: 1px;
            margin: 5px 0;
            background-color: #eee;
        }
        /* Hapus hover CSS yang lama */
        /* .user-profile:hover .dropdown-menu {
            display: block;
        } */
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="top-bar">
            <div class="top-bar-container">
                <div>Layanan Konseling Online 24 Jam</div>
                <div><i class="fas fa-phone-alt"></i> 1500-123</div>
            </div>
        </div>

        <div class="main-header">
            <div class="header-container" style="padding: 0.5%">
                <div class="logo">
                    <img src="https://placehold.co/40x40/1a73e8/FFFFFF?text=MC" alt="Logo MindCare">
                    <span>{{ $title ?? config('app.name') }}</span>
                </div>

                <div class="user-actions">
                    @guest
                        <!-- Jika belum login -->
                        <a href="{{ route('login.form') }}" class="register">Masuk</a>
                        <a href="{{ route('register.student') }}" class="login">Daftar Mahasiswa</a>
                        <a href="{{ route('register.counselor') }}" class="login">Daftar Dosen</a>
                    @else
                        @php
                            $user = Auth::user();
                            $name = $user->name;
                            $photo = asset('storage/default.jpg'); // default avatar

                            if ($user->role === 'student' && $user->student) {
                                $name = $user->student->name;
                                $photo = asset('storage/'.$user->student->image);
                            } elseif ($user->role === 'counselor' && $user->counselor) {
                                $name = $user->counselor->name;
                                $photo = asset('storage/'.$user->counselor->image);
                            }
                        @endphp

                        <!-- Jika sudah login -->
                        <div class="user-profile dropdown">
                            <button class="dropdown-toggle" id="dropdownToggle">
                                <img src="{{ $photo }}" alt="User Profile" style="border-radius: 50%; width: 40px; height: 40px;">
                                <span>Hi, {{ $name }}</span>
                                <i class="fas fa-caret-down"></i>
                            </button>

                            <div class="dropdown-menu" id="dropdownMenu">
                                <a href="{{ route('profile') }}" class="dropdown-item" style="margin: 0;">
                                    <i class="fas fa-user-circle" style="margin-right: 8px;"></i> Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="dropdown-logout">
                                        <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>

        <nav>
            <div class="nav-container">
                <ul class="main-nav">
                    <li><a href="{{ route('homepage') }}"><i class="fas fa-home"></i> Beranda</a></li>
                    <li><a href="{{ route('appointments.index') }}"><i class="fas fa-calendar-check"></i> Appointment</a></li>
                    <li><a href="{{ route('counselors.index') }}"><i class="fas fa-user-md"></i> Konselor</a></li>
                </ul>
            </div>
        </nav>
    </header>

    {{ $slot }}

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-about">
                <div class="footer-logo">
                    <img src="https://placehold.co/30x30/1a73e8/FFFFFF?text=MC" alt="Logo MindCare">
                    <span>{{ $title ?? config('app.name') }}</span>
                </div>
                <p>Platform konseling online terpercaya yang menghubungkan Anda dengan psikolog dan konselor profesional untuk kesehatan mental yang lebih baik.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <h3>Perusahaan</h3>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Tim Kami</a></li>
                    <li><a href="#">Karir</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h3>Layanan</h3>
                <ul>
                    <li><a href="#">Konseling Individu</a></li>
                    <li><a href="#">Konseling Pasangan</a></li>
                    <li><a href="#">Konseling Remaja</a></li>
                    <li><a href="#">Konseling Karir</a></li>
                    <li><a href="#">Tes Psikologi</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h3>Hubungi Kami</h3>
                <ul>
                    <li><i class="fas fa-phone-alt"></i> 1500-123</li>
                    <li><i class="fas fa-envelope"></i> hello@mindcare.id</li>
                    <li><i class="fas fa-map-marker-alt"></i> Jl. Kesehatan Mental No. 123, Jakarta</li>
                    <li><i class="fas fa-clock"></i> Senin-Minggu, 24 Jam</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2023 MindCare. All rights reserved.</p>
        </div>
    </footer>
    <script>
        // Simple JavaScript for demonstration
        document.addEventListener('DOMContentLoaded', function() {
            // Change navbar background on scroll
            window.addEventListener('scroll', function() {
                const nav = document.querySelector('nav');
                if (window.scrollY > 50) {
                    nav.style.position = 'fixed';
                    nav.style.top = '0';
                    nav.style.width = '100%';
                } else {
                    nav.style.position = 'relative';
                }
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Simulate counselor rating hover effect
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

            // Dropdown menu functionality
            const dropdownToggle = document.getElementById('dropdownToggle');
            const dropdownMenu = document.getElementById('dropdownMenu');

            if (dropdownToggle && dropdownMenu) {
                // Toggle dropdown when clicking the toggle button
                dropdownToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('show');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownMenu.contains(e.target) && !dropdownToggle.contains(e.target)) {
                        dropdownMenu.classList.remove('show');
                    }
                });

                // Prevent dropdown from closing when clicking inside it
                dropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
</body>
</html>
