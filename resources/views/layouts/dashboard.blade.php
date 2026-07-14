<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Dashboard') — Tumbuh</title>
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
        body{ font-family:'Inter', sans-serif; color:var(--ink); background:var(--bg-soft); }
        .font-display{ font-family:'Sora', sans-serif; }
        .font-mono{ font-family:'JetBrains Mono', monospace; }

        .nav-item{ transition:all .2s ease; }
        .nav-item:hover{ background:var(--accent-soft); color:var(--dark-red); }
        .nav-item.active{ background:var(--dark-red); color:#fff; }

        .btn-primary{ background:var(--accent); box-shadow:0 8px 18px -6px rgba(230,57,70,0.4); transition:all .25s ease; }
        .btn-primary:hover{ background:var(--dark-red); transform:translateY(-1px); box-shadow:0 10px 22px -6px rgba(168,36,36,0.45); }

        .btn-outline{ border:1.5px solid var(--line); color:var(--muted); transition:all .2s ease; }
        .btn-outline:hover{ border-color:var(--accent); color:var(--dark-red); background:var(--accent-soft); }

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
        .input-field.error{ border-color:#f3b4b8; background:var(--accent-soft); }

        select.input-field{
            appearance:none;
            -webkit-appearance:none;
            -moz-appearance:none;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%238A7D7A' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat:no-repeat;
            background-position:right 0.9rem center;
            background-size:15px 15px;
            padding-right:2.75rem;
            cursor:pointer;
        }
        select.input-field:invalid{ color:#B9AEAB; }

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
        }

        .section-card{
            background:#fff;
            border-radius:1rem;
            border:1px solid var(--line);
            padding:1.5rem;
        }

        .badge{
            display:inline-flex;
            align-items:center;
            gap:0.4rem;
            padding:0.3rem 0.8rem;
            border-radius:9999px;
            font-size:0.75rem;
            font-weight:600;
            font-family:'JetBrains Mono', monospace;
        }
        .row-hover:hover{ background:var(--accent-soft); }

        #sidebar{ transition:transform .3s ease; }
        @media (max-width:1023px){
            #sidebar{ transform:translateX(-100%); }
            .sidebar-open #sidebar{ transform:translateX(0); }
        }

        .pagination-theme nav > div:first-child{ display:none; }
        .pagination-theme nav span[aria-current] span{ background:var(--dark-red) !important; border-color:var(--dark-red) !important; color:#fff !important; }
        .pagination-theme nav a, .pagination-theme nav span{ border-radius:0.65rem !important; font-family:'JetBrains Mono', monospace !important; font-size:0.8rem !important; }
        .pagination-theme nav a:hover{ background:var(--accent-soft) !important; }
    </style>
</head>
<body class="antialiased">
<div class="min-h-screen flex" id="app-shell">

    <!-- side bar -->
    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-white border-r flex flex-col" style="border-color:var(--line)">
        <a href="{{ route('stunting.index') }}" class="h-20 flex items-center gap-2.5 px-6 border-b" style="border-color:var(--line)">
            <span class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:var(--dark-red)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M4 20V6M4 20h4M4 16h3M4 12h4M4 8h3" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                    <path d="M4 18c4-2 8-8 16-14" stroke="#F7B7B7" stroke-width="2" stroke-linecap="round" stroke-dasharray="1 4"/>
                </svg>
            </span>
            <span class="font-display font-bold text-lg">Tumbuh</span>
        </a>

        <nav class="flex-1 px-4 py-6 space-y-1.5">
            <a href="{{ route('stunting.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('stunting.index') ? 'active' : '' }}"
               style="{{ request()->routeIs('stunting.index') ? '' : 'color:var(--ink)' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.7"/><rect x="13" y="3" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.7"/><rect x="3" y="13" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.7"/><rect x="13" y="13" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.7"/></svg>
                Dashboard
            </a>
            <a href="{{ route('stunting.create') }}"
               class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('stunting.create') || request()->routeIs('stunting.store') ? 'active' : '' }}"
               style="{{ request()->routeIs('stunting.create') || request()->routeIs('stunting.store') ? '' : 'color:var(--ink)' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M8 4h8a2 2 0 012 2v14l-6-3-6 3V6a2 2 0 012-2z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
                Buat Prediksi
            </a>
            <a href="#" class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold" style="color:var(--ink)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.7"/><path d="M19.4 13a7.97 7.97 0 000-2l2-1.6-2-3.4-2.4 1a8 8 0 00-1.7-1L15 3h-4l-.3 2.6a8 8 0 00-1.7 1l-2.4-1-2 3.4L6.6 11a8 8 0 000 2l-2 1.6 2 3.4 2.4-1c.5.4 1.1.7 1.7 1L11 21h4l.3-2.6c.6-.3 1.2-.6 1.7-1l2.4 1 2-3.4z" stroke="currentColor" stroke-width="1.5"/></svg>
                Pengaturan
            </a>
        </nav>

        <div class="p-4 border-t space-y-2" style="border-color:var(--line)">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl" style="background:var(--bg-soft)">
                @php $userName = auth()->user()->name ?? 'Guest'; @endphp
                <div class="w-9 h-9 rounded-full flex items-center justify-center font-display font-bold text-sm text-white shrink-0" style="background:var(--dark-red)">
                    {{ strtoupper(substr($userName, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold truncate">{{ $userName }}</p>
                    <p class="text-xs truncate" style="color:var(--muted)">Tenaga Kesehatan</p>
                </div>
            </div>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="nav-item w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold text-left"
                            style="color:var(--dark-red)">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Keluar
                    </button>
                </form>
            @endauth
        </div>
    </aside>

    <div id="sidebar-backdrop" onclick="document.getElementById('app-shell').classList.remove('sidebar-open')"
         class="fixed inset-0 bg-black/30 z-30 hidden lg:hidden"></div>

    <!-- MAIN -->
    <div class="flex-1 min-w-0">
        <header class="min-h-20 bg-white/90 backdrop-blur border-b flex flex-wrap items-center justify-between gap-4 px-6 lg:px-10 py-4 sticky top-0 z-20" style="border-color:var(--line)">
            <div class="flex items-center gap-3">
                <button onclick="document.getElementById('app-shell').classList.toggle('sidebar-open'); document.getElementById('sidebar-backdrop').classList.toggle('hidden')"
                        class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg border shrink-0" style="border-color:var(--line)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 7h16M4 12h16M4 17h16" stroke="var(--ink)" stroke-width="2" stroke-linecap="round"/></svg>
                </button>
                <div>
                    <h1 class="font-display font-bold text-xl tracking-tight">@yield('page-title')</h1>
                    <p class="text-xs" style="color:var(--muted)">@yield('page-subtitle')</p>
                </div>
            </div>
            <div>@yield('header-action')</div>
        </header>

        <main class="p-6 lg:p-10">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>