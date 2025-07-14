<x-layout>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            @foreach ($herosection as $itemhero)
                <h1>{{ $itemhero->title }}</h1>
                <p>{{ $itemhero->subtitle }}</p>
                <div class="hero-buttons">
                    <a href="{{ route('counselors.index') }}" class="btn btn-primary">{{ $itemhero->cta_text }}</a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Services Section -->
    <section class="services">
        <div class="section-container">
            <div class="section-title">
                <h2>Layanan Kami</h2>
                <p>Berbagai layanan konseling profesional untuk mendukung kesehatan mental Anda</p>
            </div>

            <div class="service-grid">
                @foreach ($service as $itemservice)
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="{{ $itemservice->icon_class }}"></i>
                        </div>
                        <h3>{{ $itemservice->title }}</h3>
                        <p>{{ $itemservice->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Counselors Section -->
    <section class="counselors">
        <div class="section-container">
            <div class="section-title">
                <h2>Konselor Kami</h2>
                <p>Tim Dosen Siap Membantu Anda</p>
            </div>

            <div class="counselor-grid">
                @foreach ($counselor as $item)
                    <div class="counselor-card">
                        <div class="counselor-image" style="background-image: url('{{ asset('storage/'.$item->image) }}');"></div>
                        <div class="counselor-info">
                            <h3>{{ $item->name }}</h3>
                            <span class="counselor-specialty">{{ $item->education }}</span>
                            <p class="counselor-bio">{{ $item->experience }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="section-container">
            <div class="section-title">
                <h2>Apa Kata Klien Kami</h2>
                <p>Pengalaman nyata dari mereka yang telah menggunakan layanan kami</p>
            </div>

            <div class="testimonial-grid">
                @foreach ($testimonial as $itemtesty)
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            {{ $itemtesty->description }}
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar" style="background-image: url('{{ asset('storage/'.$itemtesty->image) }}');"></div>
                            <div class="author-info">
                                <h4>{{ $itemtesty->student_name }}</h4>
                                <p>Angkatan {{ $itemtesty->class_of }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>
