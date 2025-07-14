<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi Online | SehatPlus</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Gaya dari halaman utama yang sama */
        :root {
            --primary-color: #1a73e8;
            --primary-dark: #0d47a1;
            --primary-light: #e8f0fe;
            --secondary-color: #f8f9fa;
            --text-color: #333;
            --text-light: #777;
            --white: #fff;
            --chat-user: #e3f2fd;
            --chat-counselor: #f1f1f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: var(--text-color);
        }

        /* Header - sama dengan halaman utama */
        header {
            background-color: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .top-bar {
            background-color: var(--primary-dark);
            color: var(--white);
            padding: 8px 0;
            font-size: 14px;
        }

        .top-bar-container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .main-header {
            padding: 15px 0;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 40px;
        }

        .logo span {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
            margin-left: 10px;
        }

        .search-bar {
            flex-grow: 1;
            margin: 0 30px;
            position: relative;
        }

        .search-bar input {
            width: 100%;
            padding: 12px 20px;
            border-radius: 25px;
            border: 1px solid #ddd;
            font-size: 14px;
            outline: none;
            padding-left: 45px;
        }

        .search-bar i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: var(--text-light);
        }

        .user-actions a {
            margin-left: 20px;
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
        }

        .user-actions a.login {
            color: var(--primary-color);
        }

        .user-actions a.register {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        /* Navigation */
        nav {
            background-color: var(--primary-color);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .main-nav {
            display: flex;
            list-style: none;
        }

        .main-nav li {
            position: relative;
        }

        .main-nav li a {
            color: var(--white);
            text-decoration: none;
            display: block;
            padding: 15px 20px;
            font-size: 15px;
            transition: background-color 0.3s;
        }

        .main-nav li a:hover {
            background-color: var(--primary-dark);
        }

        .main-nav li a i {
            margin-right: 8px;
        }

        /* Chat Container */
        .chat-container {
            max-width: 1200px;
            margin: 30px auto;
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 20px;
            padding: 0 20px;
        }

        /* Chat List */
        .chat-list {
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .chat-list-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-list-header h2 {
            font-size: 18px;
            color: var(--primary-dark);
        }

        .new-chat-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
        }

        .chat-search {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .chat-search input {
            width: 100%;
            padding: 10px 15px;
            border-radius: 20px;
            border: 1px solid #ddd;
            font-size: 14px;
            padding-left: 40px;
        }

        .chat-search i {
            position: absolute;
            left: 30px;
            top: 25px;
            color: var(--text-light);
        }

        .chat-items {
            height: calc(100vh - 280px);
            overflow-y: auto;
        }

        .chat-item {
            display: flex;
            padding: 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .chat-item:hover, .chat-item.active {
            background-color: var(--primary-light);
        }

        .chat-item-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #ddd;
            background-size: cover;
            margin-right: 15px;
        }

        .chat-item-info {
            flex-grow: 1;
        }

        .chat-item-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .chat-item-name {
            font-weight: 600;
            color: var(--text-color);
        }

        .chat-item-time {
            font-size: 12px;
            color: var(--text-light);
        }

        .chat-item-preview {
            font-size: 14px;
            color: var(--text-light);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-item.unread .chat-item-name {
            font-weight: bold;
        }

        .chat-item.unread .chat-item-preview {
            color: var(--text-color);
            font-weight: 500;
        }

        /* Chat Area */
        .chat-area {
            display: flex;
            flex-direction: column;
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .chat-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }

        .chat-header-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddd;
            background-size: cover;
            margin-right: 15px;
        }

        .chat-header-info h3 {
            font-size: 16px;
            color: var(--text-color);
        }

        .chat-header-info p {
            font-size: 13px;
            color: var(--text-light);
        }

        .chat-status {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .chat-status .online {
            width: 10px;
            height: 10px;
            background-color: #4caf50;
            border-radius: 50%;
            margin-right: 5px;
        }

        .chat-messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            height: calc(100vh - 400px);
            background-color: #f9f9f9;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .message-content {
            max-width: 70%;
            padding: 12px 15px;
            border-radius: 18px;
            position: relative;
            word-wrap: break-word;
        }

        .message-user .message-content {
            background-color: var(--chat-user);
            align-self: flex-end;
            border-bottom-right-radius: 0;
        }

        .message-counselor .message-content {
            background-color: var(--chat-counselor);
            align-self: flex-start;
            border-bottom-left-radius: 0;
        }

        .message-info {
            display: flex;
            margin-top: 5px;
            font-size: 12px;
            color: var(--text-light);
        }

        .message-user .message-info {
            justify-content: flex-end;
        }

        .message-counselor .message-info {
            justify-content: flex-start;
        }

        .message-time {
            margin: 0 5px;
        }

        .chat-input {
            padding: 15px;
            border-top: 1px solid #eee;
            display: flex;
            align-items: center;
        }

        .chat-input input {
            flex-grow: 1;
            padding: 12px 15px;
            border-radius: 25px;
            border: 1px solid #ddd;
            font-size: 14px;
            outline: none;
            margin-right: 10px;
        }

        .send-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Group Chat Info */
        .chat-info {
            padding: 20px;
            border-left: 1px solid #eee;
            width: 300px;
            background-color: var(--white);
        }

        .chat-info-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chat-info-header h3 {
            font-size: 18px;
            color: var(--primary-dark);
        }

        .close-info {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--text-light);
        }

        .group-members {
            margin-bottom: 30px;
        }

        .group-members h4 {
            margin-bottom: 15px;
            color: var(--text-color);
        }

        .member-list {
            list-style: none;
        }

        .member-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .member-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddd;
            background-size: cover;
            margin-right: 10px;
        }

        .member-info h5 {
            font-size: 15px;
            margin-bottom: 3px;
        }

        .member-info p {
            font-size: 13px;
            color: var(--text-light);
        }

        .member-status {
            width: 10px;
            height: 10px;
            background-color: #4caf50;
            border-radius: 50%;
            margin-left: auto;
        }

        .chat-actions h4 {
            margin-bottom: 15px;
            color: var(--text-color);
        }

        .action-btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background-color: var(--primary-light);
            color: var(--primary-color);
            border: none;
            border-radius: 5px;
            text-align: left;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .action-btn:hover {
            background-color: #dbe7ff;
        }

        .action-btn i {
            margin-right: 10px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .chat-container {
                grid-template-columns: 1fr;
            }

            .chat-items {
                height: auto;
                max-height: 300px;
            }

            .chat-messages {
                height: 400px;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
            }

            .logo {
                margin-bottom: 15px;
            }

            .search-bar {
                width: 100%;
                margin: 15px 0;
            }

            .user-actions {
                width: 100%;
                display: flex;
                justify-content: space-between;
            }

            .main-nav {
                overflow-x: auto;
                white-space: nowrap;
                padding: 10px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="top-bar">
            <div class="top-bar-container">
                <div>Layanan Kesehatan Terpercaya</div>
                <div><i class="fas fa-phone-alt"></i> 1500-005</div>
            </div>
        </div>

        <div class="main-header">
            <div class="header-container">
                <div class="logo">
                    <img src="https://via.placeholder.com/40x40" alt="Logo">
                    <span>SehatPlus</span>
                </div>

                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari dokter, penyakit, obat, artikel...">
                </div>

                <div class="user-actions">
                    <a href="#" class="login">Masuk</a>
                    <a href="#" class="register">Daftar</a>
                </div>
            </div>
        </div>

        <nav>
            <div class="nav-container">
                <ul class="main-nav">
                    <li><a href="index.html"><i class="fas fa-home"></i> Beranda</a></li>
                    <li><a href="#"><i class="fas fa-user-md"></i> Dokter</a></li>
                    <li><a href="#"><i class="fas fa-pills"></i> Obat</a></li>
                    <li><a href="#"><i class="fas fa-hospital"></i> Rumah Sakit</a></li>
                    <li><a href="#"><i class="fas fa-book"></i> Artikel</a></li>
                    <li><a href="chat.html" class="active"><i class="fas fa-comments"></i> Konsultasi</a></li>
                    <li><a href="janji-konselor.html"><i class="fas fa-calendar-check"></i> Buat Janji</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Chat Container -->
    <div class="chat-container">
        <!-- Chat List -->
        <div class="chat-list">
            <div class="chat-list-header">
                <h2>Pesan</h2>
                <button class="new-chat-btn"><i class="fas fa-plus"></i> Baru</button>
            </div>

            <div class="chat-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari percakapan...">
            </div>

            <div class="chat-items">
                <div class="chat-item active">
                    <div class="chat-item-avatar" style="background-image: url('https://via.placeholder.com/150');"></div>
                    <div class="chat-item-info">
                        <div class="chat-item-header">
                            <span class="chat-item-name">Dr. Sarah Wijaya</span>
                            <span class="chat-item-time">12:30</span>
                        </div>
                        <div class="chat-item-preview">Saya akan memeriksa hasil tes Anda...</div>
                    </div>
                </div>

                <div class="chat-item unread">
                    <div class="chat-item-avatar" style="background-image: url('https://via.placeholder.com/150');"></div>
                    <div class="chat-item-info">
                        <div class="chat-item-header">
                            <span class="chat-item-name">Grup Keluarga</span>
                            <span class="chat-item-time">10:15</span>
                        </div>
                        <div class="chat-item-preview">Ibu: Hasil lab ayah sudah keluar...</div>
                    </div>
                </div>

                <div class="chat-item">
                    <div class="chat-item-avatar" style="background-image: url('https://via.placeholder.com/150');"></div>
                    <div class="chat-item-info">
                        <div class="chat-item-header">
                            <span class="chat-item-name">Dr. Ahmad Setiawan</span>
                            <span class="chat-item-time">Kemarin</span>
                        </div>
                        <div class="chat-item-preview">Obatnya sudah bisa diambil di...</div>
                    </div>
                </div>

                <div class="chat-item">
                    <div class="chat-item-avatar" style="background-image: url('https://via.placeholder.com/150');"></div>
                    <div class="chat-item-info">
                        <div class="chat-item-header">
                            <span class="chat-item-name">Admin SehatPlus</span>
                            <span class="chat-item-time">Senin</span>
                        </div>
                        <div class="chat-item-preview">Terima kasih telah menghubungi...</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="chat-area">
            <div class="chat-header">
                <div class="chat-header-avatar" style="background-image: url('https://via.placeholder.com/150');"></div>
                <div class="chat-header-info">
                    <h3>Dr. Sarah Wijaya</h3>
                    <p>Psikolog Klinis</p>
                </div>
                <div class="chat-status">
                    <span class="online"></span>
                    <span>Online</span>
                </div>
            </div>

            <div class="chat-messages">
                <div class="message message-counselor">
                    <div class="message-content">
                        Selamat siang, ada yang bisa saya bantu?
                    </div>
                    <div class="message-info">
                        <span class="message-time">12:00</span>
                    </div>
                </div>

                <div class="message message-user">
                    <div class="message-content">
                        Selamat siang dok, saya ingin berkonsultasi tentang masalah tidur saya
                    </div>
                    <div class="message-info">
                        <span class="message-time">12:02</span>
                        <span class="message-status"><i class="fas fa-check-double"></i></span>
                    </div>
                </div>

                <div class="message message-counselor">
                    <div class="message-content">
                        Saya mengerti. Bisakah Anda menjelaskan lebih detail masalah yang Anda alami? Sudah berapa lama mengalami kesulitan tidur?
                    </div>
                    <div class="message-info">
                        <span class="message-time">12:05</span>
                    </div>
                </div>

                <div class="message message-user">
                    <div class="message-content">
                        Sudah sekitar 2 minggu dok. Saya sulit memulai tidur, kadang sampai jam 2-3 pagi masih terbangun. Padahal besok harus kerja jam 7.
                    </div>
                    <div class="message-info">
                        <span class="message-time">12:07</span>
                        <span class="message-status"><i class="fas fa-check-double"></i></span>
                    </div>
                </div>

                <div class="message message-counselor">
                    <div class="message-content">
                        Saya sarankan kita membuat janji untuk konsultasi lebih lanjut. Ini bisa kita bahas lebih dalam selama 30-45 menit. Apakah Anda punya waktu hari ini jam 4 sore atau besok pagi?
                    </div>
                    <div class="message-info">
                        <span class="message-time">12:10</span>
                    </div>
                </div>

                <div class="message message-user">
                    <div class="message-content">
                        Saya bisa jam 4 sore hari ini dok. Terima kasih.
                    </div>
                    <div class="message-info">
                        <span class="message-time">12:12</span>
                        <span class="message-status"><i class="fas fa-check"></i></span>
                    </div>
                </div>

                <div class="message message-counselor">
                    <div class="message-content">
                        Baik, saya sudah catat janjinya. Nanti akan ada notifikasi reminder 1 jam sebelum sesi dimulai. Sampai jumpa nanti.
                    </div>
                    <div class="message-info">
                        <span class="message-time">12:15</span>
                    </div>
                </div>
            </div>

            <div class="chat-input">
                <input type="text" placeholder="Ketik pesan...">
                <button class="send-btn"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>

        <!-- Group Chat Info (akan muncul saat grup dipilih) -->
        <div class="chat-info" style="display: none;">
            <div class="chat-info-header">
                <h3>Info Grup</h3>
                <button class="close-info"><i class="fas fa-times"></i></button>
            </div>

            <div class="group-members">
                <h4>Anggota (4)</h4>
                <ul class="member-list">
                    <li class="member-item">
                        <div class="member-avatar" style="background-image: url('https://via.placeholder.com/150');"></div>
                        <div class="member-info">
                            <h5>Andi Wijaya</h5>
                            <p>Anda</p>
                        </div>
                    </li>
                    <li class="member-item">
                        <div class="member-avatar" style="background-image: url('https://via.placeholder.com/150');"></div>
                        <div class="member-info">
                            <h5>Dr. Sarah Wijaya</h5>
                            <p>Psikolog</p>
                        </div>
                        <div class="member-status"></div>
                    </li>
                    <li class="member-item">
                        <div class="member-avatar" style="background-image: url('https://via.placeholder.com/150');"></div>
                        <div class="member-info">
                            <h5>Budi Santoso</h5>
                            <p>Ayah</p>
                        </div>
                    </li>
                    <li class="member-item">
                        <div class="member-avatar" style="background-image: url('https://via.placeholder.com/150');"></div>
                        <div class="member-info">
                            <h5>Siti Rahayu</h5>
                            <p>Ibu</p>
                        </div>
                        <div class="member-status"></div>
                    </li>
                </ul>
            </div>

            <div class="chat-actions">
                <h4>Aksi Grup</h4>
                <button class="action-btn"><i class="fas fa-user-plus"></i> Tambah Anggota</button>
                <button class="action-btn"><i class="fas fa-volume-mute"></i> Matikan Notifikasi</button>
                <button class="action-btn"><i class="fas fa-trash-alt"></i> Keluar dari Grup</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-about">
                <div class="footer-logo">
                    <img src="https://via.placeholder.com/30x30" alt="Logo">
                    <span>SehatPlus</span>
                </div>
                <p>Platform kesehatan terpercaya yang menghubungkan pasien dengan dokter dan fasilitas kesehatan terbaik di Indonesia.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <h3>Perusahaan</h3>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Karir</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h3>Layanan</h3>
                <ul>
                    <li><a href="#">Tanya Dokter</a></li>
                    <li><a href="janji-konselor.html">Buat Janji</a></li>
                    <li><a href="chat.html">Konsultasi Online</a></li>
                    <li><a href="#">Beli Obat</a></li>
                    <li><a href="#">Cek Lab</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h3>Hubungi Kami</h3>
                <ul>
                    <li><i class="fas fa-phone-alt"></i> 1500-005</li>
                    <li><i class="fas fa-envelope"></i> hello@sehatplus.id</li>
                    <li><i class="fas fa-map-marker-alt"></i> Jl. Kesehatan No. 123, Jakarta</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2023 SehatPlus. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Chat functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Select chat item
            document.querySelectorAll('.chat-item').forEach(item => {
                item.addEventListener('click', function() {
                    document.querySelectorAll('.chat-item').forEach(i => i.classList.remove('active'));
                    this.classList.add('active');

                    // Show group info if group chat is selected
                    if (this.querySelector('.chat-item-name').textContent === 'Grup Keluarga') {
                        document.querySelector('.chat-info').style.display = 'block';
                    } else {
                        document.querySelector('.chat-info').style.display = 'none';
                    }
                });
            });

            // Close group info
            document.querySelector('.close-info').addEventListener('click', function() {
                document.querySelector('.chat-info').style.display = 'none';
            });

            // Send message
            document.querySelector('.send-btn').addEventListener('click', sendMessage);
            document.querySelector('.chat-input input').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });

            function sendMessage() {
                const input = document.querySelector('.chat-input input');
                const message = input.value.trim();

                if (message) {
                    const messagesContainer = document.querySelector('.chat-messages');

                    // Create new message element
                    const messageElement = document.createElement('div');
                    messageElement.className = 'message message-user';
                    messageElement.innerHTML = `
                        <div class="message-content">${message}</div>
                        <div class="message-info">
                            <span class="message-time">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                            <span class="message-status"><i class="fas fa-check"></i></span>
                        </div>
                    `;

                    // Add to messages container
                    messagesContainer.appendChild(messageElement);

                    // Scroll to bottom
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;

                    // Clear input
                    input.value = '';

                    // Simulate reply after 1-3 seconds
                    setTimeout(simulateReply, 1000 + Math.random() * 2000);
                }
            }

            function simulateReply() {
                const replies = [
                    "Saya memahami kekhawatiran Anda. Bisakah Anda menjelaskan lebih detail?",
                    "Apakah Anda sudah mencoba teknik relaksasi sebelum tidur?",
                    "Saya sarankan kita buat janji untuk membahas ini lebih lanjut.",
                    "Masalah tidur bisa disebabkan oleh berbagai faktor, termasuk stres. Bagaimana kondisi Anda akhir-akhir ini?",
                    "Apakah Anda mengonsumsi kafein di sore atau malam hari?"
                ];

                const randomReply = replies[Math.floor(Math.random() * replies.length)];
                const messagesContainer = document.querySelector('.chat-messages');

                const replyElement = document.createElement('div');
                replyElement.className = 'message message-counselor';
                replyElement.innerHTML = `
                    <div class="message-content">${randomReply}</div>
                    <div class="message-info">
                        <span class="message-time">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                    </div>
                `;

                messagesContainer.appendChild(replyElement);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });
    </script>
</body>
</html>
