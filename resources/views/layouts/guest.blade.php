<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Tumbuh') }}</title>
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
            --success:#2F9E5B;
            --success-soft:#E6F6ED;
        }
        body{ font-family:'Inter', sans-serif; color:var(--ink); }
        .font-display{ font-family:'Sora', sans-serif; }
        .font-mono{ font-family:'JetBrains Mono', monospace; }

        .input-field{
            width:100%;
            padding:0.65rem 1rem;
            border-radius:0.75rem;
            font-size:0.875rem;
            line-height:1.4;
            font-family:'Inter', sans-serif;
            background:#fff;
            color:var(--ink);
            outline:none;
            border:1.5px solid var(--line);
            transition:border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
        }
        .input-field::placeholder{ color:#B9AEAB; }
        .input-field:focus{ border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-soft); }

        .field-label{
            display:block;
            font-size:0.75rem;
            font-weight:600;
            text-transform:uppercase;
            letter-spacing:0.03em;
            margin-bottom:0.4rem;
            color:var(--muted);
        }
        .field-error{
            font-size:0.75rem;
            margin-top:0.4rem;
            display:flex;
            align-items:center;
            gap:0.25rem;
            color:var(--dark-red);
            list-style:none;
            padding:0;
        }

        .btn-primary{
            background:var(--accent);
            box-shadow:0 8px 18px -6px rgba(230,57,70,0.4);
            transition:all .25s ease;
            border:none;
            cursor:pointer;
        }
        .btn-primary:hover{ background:var(--dark-red); transform:translateY(-1px); box-shadow:0 10px 22px -6px rgba(168,36,36,0.45); }
        .btn-primary:disabled{ opacity:0.6; cursor:not-allowed; transform:none; }

        input[type="checkbox"]{ accent-color:var(--accent); }

        .link-muted{ color:var(--muted); transition:color .2s ease; }
        .link-muted:hover{ color:var(--accent); }

        .status-box{
            background:var(--success-soft);
            color:var(--success);
            border-radius:1rem;
            padding:0.9rem 1.1rem;
            font-size:0.875rem;
            font-weight:500;
            display:flex;
            align-items:center;
            gap:0.5rem;
        }
    </style>
</head>
<body class="antialiased">
<div class="min-h-screen grid lg:grid-cols-2" style="background:var(--bg-soft)">

    <!-- LEFT: brand panel -->
    <div class="hidden lg:flex flex-col justify-between p-12 relative overflow-hidden" style="background:var(--dark-red)">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 relative z-10">
            <span class="w-9 h-9 rounded-xl flex items-center justify-center bg-white/15">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M4 20V6M4 20h4M4 16h3M4 12h4M4 8h3" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                    <path d="M4 18c4-2 8-8 16-14" stroke="#F7B7B7" stroke-width="2" stroke-linecap="round" stroke-dasharray="1 4"/>
                </svg>
            </span>
            <span class="font-display font-bold text-lg text-white">Tumbuh</span>
        </a>

        <div class="relative z-10 max-w-sm">
            <h2 class="font-display font-bold text-3xl text-white leading-tight">
                Deteksi dini, langkah pasti untuk tumbuh kembang balita.
            </h2>
            <p class="text-sm mt-4" style="color:#F5C6C7">
                Kelola data & riwayat prediksi stunting balita Anda dengan aman dan mudah.
            </p>
        </div>

        <!-- decorative growth ruler illustration -->
        <svg viewBox="0 0 300 260" class="absolute -bottom-6 -right-6 w-72 opacity-90" xmlns="http://www.w3.org/2000/svg">
            <line x1="40" y1="10" x2="40" y2="240" stroke="#C24D4D" stroke-width="2" stroke-linecap="round"/>
            <line x1="34" y1="230" x2="46" y2="230" stroke="#C24D4D" stroke-width="2"/>
            <line x1="36" y1="180" x2="44" y2="180" stroke="#C24D4D" stroke-width="1.5"/>
            <line x1="36" y1="130" x2="44" y2="130" stroke="#C24D4D" stroke-width="1.5"/>
            <line x1="36" y1="80" x2="44" y2="80" stroke="#C24D4D" stroke-width="1.5"/>
            <line x1="34" y1="30" x2="46" y2="30" stroke="#C24D4D" stroke-width="2"/>
            <path d="M40 232 C 90 210, 110 170, 140 140 S 200 90, 230 55"
                  fill="none" stroke="#F5C6C7" stroke-width="3" stroke-linecap="round" stroke-dasharray="1 8"/>
            <path d="M40 232 C 80 218, 100 190, 130 165 C 165 135, 190 110, 235 70"
                  fill="none" stroke="#FDEAEA" stroke-width="4" stroke-linecap="round"/>
            <circle cx="40" cy="232" r="5" fill="#fff"/>
            <circle cx="235" cy="70" r="6" fill="#fff"/>
        </svg>

        <p class="relative z-10 text-xs" style="color:#E5A7A8">© {{ date('Y') }} Tumbuh. Alat bantu skrining, bukan pengganti diagnosis medis.</p>
    </div>

    <!-- RIGHT: form panel -->
    <div class="flex items-center justify-center p-6 sm:p-10">
        <div class="w-full max-w-sm">

            <!-- mobile logo -->
            <a href="{{ route('home') }}" class="lg:hidden flex items-center gap-2.5 mb-8">
                <span class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:var(--dark-red)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M4 20V6M4 20h4M4 16h3M4 12h4M4 8h3" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                        <path d="M4 18c4-2 8-8 16-14" stroke="#F7B7B7" stroke-width="2" stroke-linecap="round" stroke-dasharray="1 4"/>
                    </svg>
                </span>
                <span class="font-display font-bold text-lg">Tumbuh</span>
            </a>

            {{ $slot }}
        </div>
    </div>
</div>
</body>
</html>