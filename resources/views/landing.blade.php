<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tumbuh — Deteksi Dini Risiko Stunting</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <style>
        :root{
            --ink:#241B1B;
            --muted:#8A7D7A;
            --line:#EEE3E2;
            --dark-red:#A82424;
            --accent:#E63946;
            --accent-soft:#FDEAEA;
            --bg-soft:#FDF8F7;
        }
        body{ font-family:'Inter', sans-serif; color:var(--ink); }
        .font-display{ font-family:'Sora', sans-serif; }
        .font-mono{ font-family:'JetBrains Mono', monospace; }

        .btn-primary{
            background:var(--accent);
            box-shadow:0 8px 20px -6px rgba(230,57,70,0.45);
        }
        .btn-primary:hover{ background:var(--dark-red); box-shadow:0 10px 24px -6px rgba(168,36,36,0.5); transform:translateY(-2px); }

        .btn-ghost:hover{ background:var(--dark-red); color:#fff; }

        .ruler-rule{
            background-image:repeating-linear-gradient(90deg, var(--dark-red) 0 2px, transparent 2px 14px);
            height:2px;
        }

        .feature-card{ transition:all .35s ease; }
        .feature-card:hover{ transform:translateY(-6px); border-color:var(--accent); box-shadow:0 20px 40px -20px rgba(168,36,36,0.35); }

        @media (prefers-reduced-motion: reduce){
            .feature-card, .btn-primary, .mobile-nav{ transition:none !important; }
        }
    </style>
</head>
<body class="bg-white antialiased">

<!-- NAVBAR -->
<header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b" style="border-color:var(--line)">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 h-20 flex items-center justify-between">

        <!-- Logo -->
        <a href="#" class="flex items-center gap-2.5">
            <span class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:var(--dark-red)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M4 20V6M4 20h4M4 16h3M4 12h4M4 8h3" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                    <path d="M4 18c4-2 8-8 16-14" stroke="#F7B7B7" stroke-width="2" stroke-linecap="round" stroke-dasharray="1 4"/>
                </svg>
            </span>
            <span class="font-display font-bold text-lg tracking-tight">Tumbuh</span>
        </a>

        <!-- Center nav (desktop) -->
        <nav class="hidden md:flex items-center gap-9 text-sm font-medium" style="color:var(--ink)">
            <a href="#beranda" class="hover:text-[var(--accent)] transition-colors">Beranda</a>
            <a href="#fitur" class="hover:text-[var(--accent)] transition-colors">Fitur</a>
            <a href="#tentang" class="hover:text-[var(--accent)] transition-colors">Tentang</a>
            <a href="#faq" class="hover:text-[var(--accent)] transition-colors">FAQ</a>
        </nav>

        <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}"
                    class="hidden sm:inline-flex items-center px-5 py-2.5 rounded-full text-sm font-semibold text-white transition-all duration-300"
                    style="background:var(--dark-red)">
                        Masuk / Daftar
                    </a>
                @endguest

                @auth
                    <a href="{{ route('stunting.index') }}"
                    class="hidden sm:inline-flex items-center px-5 py-2.5 rounded-full text-sm font-semibold text-white transition-all duration-300"
                    style="background:var(--dark-red)">
                        Dashboard
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="hidden sm:inline-flex items-center px-5 py-2.5 rounded-full text-sm font-semibold border"
                            style="border-color:var(--dark-red); color:var(--dark-red)">
                            Logout
                        </button>
                    </form>
                @endauth
            <!-- Mobile menu button -->
            <button onclick="document.getElementById('mnav').classList.toggle('hidden')"
                    class="md:hidden w-10 h-10 flex items-center justify-center rounded-lg border" style="border-color:var(--line)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 7h16M4 12h16M4 17h16" stroke="var(--ink)" stroke-width="2" stroke-linecap="round"/></svg>
            </button>
        </div>
    </div>

    <!-- Mobile nav -->
    <nav id="mnav" class="mobile-nav hidden md:hidden flex flex-col gap-1 px-6 pb-5 text-sm font-medium border-t" style="border-color:var(--line)">
        <a href="#beranda" class="py-2.5">Beranda</a>
        <a href="#fitur" class="py-2.5">Fitur</a>
        <a href="#tentang" class="py-2.5">Tentang</a>
        <a href="#faq" class="py-2.5">FAQ</a>
        <a href="#" class="mt-2 text-center px-5 py-2.5 rounded-full text-white font-semibold" style="background:var(--dark-red)">Masuk / Daftar</a>
    </nav>
</header>

<!-- HERO -->
<section id="beranda" class="relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 pt-16 pb-20 lg:pt-24 lg:pb-28 grid lg:grid-cols-2 gap-14 items-center">

        <div>
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider px-3 py-1.5 rounded-full"
                  style="background:var(--accent-soft); color:var(--dark-red)">
                <span class="w-1.5 h-1.5 rounded-full" style="background:var(--accent)"></span>
                Skrining Tumbuh Kembang Berbasis AI
            </span>

            <h1 class="font-display font-extrabold text-4xl sm:text-5xl lg:text-[3.4rem] leading-[1.08] tracking-tight mt-6">
                Kenali Risiko <span style="color:var(--accent)">Stunting</span> Sebelum Terlambat Bertumbuh
            </h1>

            <p class="text-base sm:text-lg mt-5 max-w-lg" style="color:var(--muted)">
                Masukkan data pertumbuhan balita Anda, dan biarkan model machine learning kami membantu tenaga kesehatan mendeteksi risiko sejak dini — cepat, akurat, dan mudah dipahami.
            </p>

            <div class="flex flex-wrap items-center gap-4 mt-9">
                @guest
                    <a href="{{ route('login') }}"
                    class="btn-primary inline-flex items-center gap-2 text-white font-semibold px-7 py-3.5 rounded-full">
                        Masuk untuk Mulai
                    </a>
                @endguest

                @auth
                    <a href="{{ route('stunting.create') }}"
                    class="btn-primary inline-flex items-center gap-2 text-white font-semibold px-7 py-3.5 rounded-full">
                        Mulai Cek Stunting
                    </a>
                @endauth
                <a href="#fitur"
                   class="btn-ghost inline-flex items-center gap-2 font-semibold px-7 py-3.5 rounded-full border-2 transition-all duration-300"
                   style="border-color:var(--dark-red); color:var(--dark-red)">
                    Pelajari Fitur
                </a>
            </div>

            <p class="text-xs mt-7 flex items-center gap-2" style="color:var(--muted)">
                <span class="font-mono">✓</span> Dirancang bersama tenaga kesehatan &amp; kader Posyandu
            </p>
        </div>

        <!-- SIGNATURE ILLUSTRATION: growth ruler -->
        <div class="relative flex justify-center lg:justify-end">
            <div class="absolute -inset-6 rounded-[2.5rem] -z-10" style="background:var(--bg-soft)"></div>
            <svg viewBox="0 0 440 420" class="w-full max-w-md drop-shadow-sm" xmlns="http://www.w3.org/2000/svg">
                <!-- ruler baseline -->
                <line x1="60" y1="30" x2="60" y2="380" stroke="var(--dark-red)" stroke-width="3" stroke-linecap="round"/>
                <!-- ticks + labels (usia dalam bulan, 0-60) -->
                <g font-family="JetBrains Mono, monospace" font-size="11" fill="var(--muted)">
                    <line x1="52" y1="370" x2="68" y2="370" stroke="var(--dark-red)" stroke-width="3"/>
                    <text x="30" y="374">0</text>
                    <line x1="55" y1="310" x2="65" y2="310" stroke="var(--dark-red)" stroke-width="2"/>
                    <text x="22" y="314">12</text>
                    <line x1="55" y1="250" x2="65" y2="250" stroke="var(--dark-red)" stroke-width="2"/>
                    <text x="22" y="254">24</text>
                    <line x1="55" y1="190" x2="65" y2="190" stroke="var(--dark-red)" stroke-width="2"/>
                    <text x="22" y="194">36</text>
                    <line x1="55" y1="130" x2="65" y2="130" stroke="var(--dark-red)" stroke-width="2"/>
                    <text x="22" y="134">48</text>
                    <line x1="52" y1="70" x2="68" y2="70" stroke="var(--dark-red)" stroke-width="3"/>
                    <text x="22" y="74">60</text>
                    <text x="14" y="46" font-weight="600" fill="var(--dark-red)">bulan</text>
                </g>

                <!-- ideal growth curve -->
                <path d="M60 365 C 130 340, 160 300, 190 260 S 260 190, 300 150 S 370 90, 400 55"
                      fill="none" stroke="#F3B4B8" stroke-width="3" stroke-linecap="round" stroke-dasharray="2 9"/>

                <!-- actual measured curve (accent) -->
                <path d="M60 365 C 120 350, 150 320, 185 285 C 230 245, 260 210, 320 140"
                      fill="none" stroke="var(--accent)" stroke-width="4" stroke-linecap="round"/>

                <!-- data points -->
                <circle cx="60" cy="365" r="5" fill="var(--dark-red)"/>
                <circle cx="185" cy="285" r="5" fill="var(--dark-red)"/>
                <circle cx="320" cy="140" r="6" fill="var(--accent)"/>
                <circle cx="320" cy="140" r="10" fill="none" stroke="var(--accent)" stroke-width="2" opacity="0.4"/>

                <!-- floating result chip -->
                <g transform="translate(240,90)">
                    <rect x="0" y="0" width="150" height="52" rx="14" fill="white" stroke="var(--line)" stroke-width="1.5"/>
                    <circle cx="24" cy="26" r="9" fill="#E6F6ED"/>
                    <path d="M20 26l3 3 6-6" stroke="#2F9E5B" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    <text x="42" y="22" font-family="Inter, sans-serif" font-size="10.5" fill="var(--muted)" font-weight="600">Status Tumbuh</text>
                    <text x="42" y="37" font-family="Sora, sans-serif" font-size="13" fill="#2F9E5B" font-weight="700">Normal</text>
                </g>
            </svg>
        </div>
    </div>
</section>

<!-- RULER DIVIDER -->
<div class="max-w-7xl mx-auto px-6 lg:px-10"><div class="ruler-rule w-full"></div></div>

<!-- FEATURES -->
<section id="fitur" class="py-20 lg:py-28" style="background:var(--bg-soft)">
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="max-w-xl mb-14">
            <span class="font-mono text-xs font-semibold tracking-widest uppercase" style="color:var(--accent)">Mengapa Tumbuh</span>
            <h2 class="font-display font-bold text-3xl sm:text-4xl mt-3 tracking-tight">Dibangun untuk ketepatan yang tenaga kesehatan bisa percaya</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="feature-card bg-white rounded-2xl p-7 border" style="border-color:var(--line)">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5" style="background:var(--accent-soft)">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 2l3 6 6 1-4.5 4.5L18 20l-6-3-6 3 1.5-6.5L3 9l6-1z" stroke="var(--dark-red)" stroke-width="1.6" stroke-linejoin="round"/></svg>
                </div>
                <h3 class="font-display font-bold text-lg mb-2">Akurasi Model AI</h3>
                <p class="text-sm leading-relaxed" style="color:var(--muted)">
                    Model machine learning kami dilatih dari data antropometri balita dan terus dievaluasi agar hasil prediksi tetap relevan dan dapat dipertanggungjawabkan.
                </p>
            </div>

            <div class="feature-card bg-white rounded-2xl p-7 border" style="border-color:var(--line)">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5" style="background:var(--accent-soft)">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z" stroke="var(--dark-red)" stroke-width="1.6" stroke-linejoin="round"/><path d="M9.5 12l1.8 1.8L15 10" stroke="var(--dark-red)" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <h3 class="font-display font-bold text-lg mb-2">Keamanan Data</h3>
                <p class="text-sm leading-relaxed" style="color:var(--muted)">
                    Data balita dan keluarga tersimpan terenkripsi dan hanya dapat diakses oleh akun yang berwenang di fasilitas kesehatan Anda.
                </p>
            </div>

            <div class="feature-card bg-white rounded-2xl p-7 border" style="border-color:var(--line)">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5" style="background:var(--accent-soft)">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="3" stroke="var(--dark-red)" stroke-width="1.6"/><path d="M8 9h8M8 13h8M8 17h5" stroke="var(--dark-red)" stroke-width="1.6" stroke-linecap="round"/></svg>
                </div>
                <h3 class="font-display font-bold text-lg mb-2">Riwayat Tersimpan Rapi</h3>
                <p class="text-sm leading-relaxed" style="color:var(--muted)">
                    Setiap hasil cek tersusun otomatis dalam riwayat, memudahkan Anda memantau perkembangan balita dari waktu ke waktu.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- TENTANG -->
<section id="tentang" class="py-20 lg:py-24">
    <div class="max-w-4xl mx-auto px-6 lg:px-10 text-center">
        <span class="font-mono text-xs font-semibold tracking-widest uppercase" style="color:var(--accent)">Tentang Tumbuh</span>
        <h2 class="font-display font-bold text-2xl sm:text-3xl mt-3 tracking-tight">Membantu deteksi dini, mendukung keputusan tenaga kesehatan</h2>
        <p class="mt-4 text-sm sm:text-base leading-relaxed" style="color:var(--muted)">
            Tumbuh dikembangkan sebagai alat bantu skrining awal — bukan pengganti diagnosis medis. Setiap hasil prediksi tetap perlu dikonfirmasi oleh dokter atau tenaga gizi profesional.
        </p>
    </div>
</section>

<!-- FAQ -->
<section id="faq" class="py-20 lg:py-24" style="background:var(--bg-soft)">
    <div class="max-w-3xl mx-auto px-6 lg:px-10">
        <h2 class="font-display font-bold text-2xl sm:text-3xl tracking-tight mb-10 text-center">Pertanyaan Umum</h2>
        <div class="space-y-3">
            <details class="bg-white rounded-xl border p-5 group" style="border-color:var(--line)">
                <summary class="font-semibold cursor-pointer flex justify-between items-center">
                    Apakah hasil prediksi ini menggantikan pemeriksaan dokter?
                    <span class="transition-transform group-open:rotate-45 font-mono" style="color:var(--accent)">+</span>
                </summary>
                <p class="text-sm mt-3" style="color:var(--muted)">Tidak. Tumbuh adalah alat bantu skrining awal; hasil tetap perlu dikonsultasikan ke tenaga kesehatan.</p>
            </details>
            <details class="bg-white rounded-xl border p-5 group" style="border-color:var(--line)">
                <summary class="font-semibold cursor-pointer flex justify-between items-center">
                    Data apa saja yang perlu saya masukkan?
                    <span class="transition-transform group-open:rotate-45 font-mono" style="color:var(--accent)">+</span>
                </summary>
                <p class="text-sm mt-3" style="color:var(--muted)">Usia, jenis kelamin, berat & panjang lahir, pola nutrisi, serta kondisi lingkungan sekitar balita.</p>
            </details>
            <details class="bg-white rounded-xl border p-5 group" style="border-color:var(--line)">
                <summary class="font-semibold cursor-pointer flex justify-between items-center">
                    Apakah riwayat cek saya tersimpan?
                    <span class="transition-transform group-open:rotate-45 font-mono" style="color:var(--accent)">+</span>
                </summary>
                <p class="text-sm mt-3" style="color:var(--muted)">Ya, semua riwayat tersimpan rapi di dashboard dan dapat diakses kapan saja setelah masuk.</p>
            </details>
        </div>
    </div>
</section>

<!-- CTA STRIP -->
<section class="py-16" style="background:var(--dark-red)">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="font-display font-bold text-2xl sm:text-3xl text-white tracking-tight">Mulai pantau tumbuh kembang balita hari ini</h2>
        <a href="{{ route('stunting.create') ?? '#' }}"
           class="inline-flex items-center gap-2 mt-7 bg-white font-semibold px-7 py-3.5 rounded-full transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl"
           style="color:var(--dark-red)">
            Mulai Cek Stunting ➔
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-10 border-t" style="border-color:var(--line)">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 flex flex-col sm:flex-row justify-between items-center gap-4">
        <span class="font-display font-bold text-sm">Tumbuh</span>
        <p class="text-xs" style="color:var(--muted)">© {{ date('Y') }} Tumbuh. Alat bantu skrining, bukan pengganti diagnosis medis.</p>
    </div>
</footer>

</body>
</html>