@extends('layouts.dashboard')

@section('page-title', 'Hasil Prediksi')
@section('page-subtitle', 'Berdasarkan data yang dimasukkan')

@section('header-action')
    <a href="{{ route('stunting.index') }}"
       class="btn-outline inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2.5 rounded-full">
        ← Riwayat
    </a>
@endsection

@section('content')

@php
    use Illuminate\Support\Str;

    $isStunting = $stunting->prediction_code == 1;
    $percent = $stunting->probability_stunting_percent !== null ? round($stunting->probability_stunting_percent, 1) : null;
    $circumference = 2 * pi() * 54;
    $offset = $percent !== null ? $circumference - ($percent / 100) * $circumference : $circumference;
    $namaSebut = $stunting->nama_balita ?: 'balita ini';

    // ==== Pecah teks AI jadi beberapa section berdasarkan heading "## " ====
    $aiSections = [];
    $rawAi = trim($stunting->ai_recommendation ?? '');

    if ($rawAi !== '') {
        $parts = preg_split('/^##\s+(.+)$/m', $rawAi, -1, PREG_SPLIT_DELIM_CAPTURE);

        // teks sebelum heading pertama (kalau ada), dianggap "Ringkasan"
        $intro = trim(array_shift($parts));
        if ($intro !== '') {
            $aiSections[] = ['title' => 'Ringkasan', 'body' => $intro];
        }

        for ($i = 0; $i < count($parts); $i += 2) {
            $title = trim($parts[$i] ?? '');
            $body  = trim($parts[$i + 1] ?? '');
            if ($title !== '') {
                $aiSections[] = ['title' => $title, 'body' => $body];
            }
        }

        // fallback: kalau tidak ada heading sama sekali, tampilkan sebagai 1 section polos
        if (empty($aiSections)) {
            $aiSections[] = ['title' => 'Analisis', 'body' => $rawAi];
        }
    }

    // Ikon & warna per jenis section (cocokkan berdasarkan judul, lowercase)
    $aiMeta = [
        'ringkasan'      => ['emoji' => '📝', 'bg' => '#f1f5f9'],
        'analisis'       => ['emoji' => '🔍', 'bg' => '#eef2ff'],
        'faktor risiko'  => ['emoji' => '⚠️', 'bg' => 'var(--accent-soft)'],
        'rekomendasi'    => ['emoji' => '✅', 'bg' => 'var(--success-soft)'],
        'kesimpulan'     => ['emoji' => '📌', 'bg' => '#fef3c7'],
    ];
    $aiDefaultMeta = ['emoji' => '🤖', 'bg' => '#f1f5f9'];
@endphp

<div class="max-w-6xl">
    <div class="grid lg:grid-cols-5 gap-6 items-start">

        <!-- KOLOM KIRI: hasil utama + aksi -->
        <div class="lg:col-span-2 space-y-5">

            <div class="rounded-3xl p-6 text-center border-2"
                 style="background:{{ $isStunting ? 'var(--accent-soft)' : 'var(--success-soft)' }};
                        border-color:{{ $isStunting ? '#f3b4b8' : '#a7e0bf' }};">

                <p class="text-5xl mb-1">{{ $isStunting ? '⚠️' : '✅' }}</p>
                <h2 class="font-display font-extrabold text-2xl" style="color:{{ $isStunting ? 'var(--dark-red)' : 'var(--success)' }}">
                    {{ $isStunting ? 'STUNTING' : 'TIDAK STUNTING' }}
                </h2>
                <p class="mt-2 text-xs px-2" style="color:{{ $isStunting ? 'var(--dark-red)' : 'var(--success)' }}; opacity:.85">
                    {{ $isStunting
                        ? 'Balita terdeteksi berisiko stunting. Segera konsultasi ke dokter atau Puskesmas terdekat.'
                        : 'Pertumbuhan balita dalam kondisi normal. Pertahankan pola asuh yang baik.' }}
                </p>

                @if($percent !== null)
                <div class="flex justify-center mt-5">
                    <div class="relative w-28 h-28">
                        <svg class="w-28 h-28 -rotate-90" viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="54" fill="none" stroke="{{ $isStunting ? '#f8d2d4' : '#c9ecd8' }}" stroke-width="10"/>
                            <circle cx="60" cy="60" r="54" fill="none"
                                    stroke="{{ $isStunting ? 'var(--accent)' : 'var(--success)' }}"
                                    stroke-width="10"
                                    stroke-linecap="round"
                                    stroke-dasharray="{{ $circumference }}"
                                    stroke-dashoffset="{{ $offset }}"
                                    style="transition: stroke-dashoffset 1s ease-out;"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="font-display font-extrabold text-xl" style="color:{{ $isStunting ? 'var(--dark-red)' : 'var(--success)' }}">{{ number_format($percent, 1) }}%</span>
                            <span class="font-mono text-[9px] tracking-wide" style="color:var(--muted)">PROBABILITAS</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="flex gap-3">
                <a href="{{ route('stunting.create') }}"
                   class="btn-primary flex-1 text-center text-white font-semibold py-3 rounded-xl text-sm">
                    + Prediksi Baru
                </a>
                <a href="{{ route('stunting.index') }}"
                   class="btn-outline flex-1 text-center bg-white font-semibold py-3 rounded-xl text-sm">
                    Riwayat
                </a>
            </div>
        </div>

        <!-- KOLOM KANAN: detail data (lega, satu kolom) -->
        <div class="lg:col-span-3">
            <div class="section-card text-sm">
                <h3 class="font-display font-bold mb-1">Detail Data</h3>
                <p class="text-xs mb-4" style="color:var(--muted)">Data yang digunakan untuk prediksi</p>

                @php
                    $details = [
                        'Nama Balita' => $stunting->nama_balita ?? '-',
                        'Usia' => $stunting->usia_bulan.' bulan',
                        'Jenis Kelamin' => $stunting->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                        'Berat Lahir' => $stunting->berat_lahir_kg.' kg',
                        'Panjang Lahir' => $stunting->panjang_lahir_cm.' cm',
                        'ASI Eksklusif' => $stunting->asi_eksklusif,
                        'Protein Harian' => $stunting->protein_harian.' g',
                        'Frekuensi Makan' => $stunting->frekuensi_makan.'x/hari',
                        'Tinggi Ibu' => $stunting->tinggi_ibu_cm.' cm',
                        'Riwayat Diare' => $stunting->riwayat_diare.' kali',
                        'Pendapatan Keluarga' => 'Rp '.number_format($stunting->pendapatan_keluarga, 0, ',', '.'),
                        'Sanitasi Layak' => $stunting->sanitasi_layak,
                        'Imunisasi Lengkap' => $stunting->imunisasi_lengkap,
                        'Diprediksi oleh Admin' => $stunting->predicted_by ?? '-',
                        'Waktu' => $stunting->created_at->format('d M Y H:i'),
                    ];
                @endphp

                @foreach($details as $label => $value)
                    <div class="flex justify-between items-center py-3 border-b last:border-0" style="border-color:var(--line)">
                        <span style="color:var(--muted)">{{ $label }}</span>
                        <span class="font-semibold">{{ $value }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ===== Analisis & Rekomendasi AI — FULL WIDTH, dipecah jadi kartu per section ===== -->
    <div class="mt-6">
        <div class="flex items-center gap-2 mb-4">
            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm shrink-0"
                  style="background: var(--accent-soft);">
                🤖
            </span>
            <h3 class="font-display font-bold">Analisis & Rekomendasi AI</h3>
        </div>

        @if(count($aiSections))
            <div class="ai-sec-grid">
                @foreach($aiSections as $i => $sec)
                    @php
                        $meta = $aiMeta[strtolower($sec['title'])] ?? $aiDefaultMeta;
                    @endphp
                    <div class="section-card ai-sec-card">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs shrink-0"
                                  style="background: {{ $meta['bg'] }};">
                                {{ $meta['emoji'] }}
                            </span>
                            <h4 class="font-display font-bold text-sm">{{ $sec['title'] }}</h4>
                        </div>

                        <div id="aiSecBody{{ $i }}" class="ai-rec">
                            {!! Str::markdown($sec['body']) !!}
                        </div>
                        <div id="aiSecFade{{ $i }}" class="ai-rec-fade"></div>

                        <button type="button" class="ai-rec-toggle" data-target="{{ $i }}">
                            Lihat selengkapnya
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="section-card text-sm text-gray-500">
                Belum ada rekomendasi AI untuk data ini.
            </div>
        @endif
    </div>
</div>

<style>
    /* ===== Grid kartu section AI ===== */
    .ai-sec-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    @media (min-width: 768px) {
        .ai-sec-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .ai-sec-card {
        position: relative;
    }

    /* ===== Isi markdown ===== */
    .ai-rec {
        color: var(--muted);
        font-size: 0.875rem;
        line-height: 1.7;
        max-height: 190px;
        overflow: hidden;
        transition: max-height 0.35s ease;
    }

    .ai-rec.expanded {
        max-height: 2000px;
    }

    .ai-rec h1, .ai-rec h2, .ai-rec h3, .ai-rec h4 {
        font-family: var(--font-display, inherit);
        font-weight: 700;
        color: #1f2937;
        margin: 0.9rem 0 0.4rem;
    }
    .ai-rec h1:first-child, .ai-rec h2:first-child,
    .ai-rec h3:first-child, .ai-rec h4:first-child { margin-top: 0; }

    .ai-rec h1 { font-size: 1rem; }
    .ai-rec h2 { font-size: 0.95rem; }
    .ai-rec h3, .ai-rec h4 { font-size: 0.875rem; }

    .ai-rec p { margin: 0 0 0.75rem 0; }
    .ai-rec p:last-child { margin-bottom: 0; }

    .ai-rec strong { font-weight: 700; color: #1f2937; }
    .ai-rec em { font-style: italic; }

    .ai-rec ul, .ai-rec ol { margin: 0.4rem 0 0.9rem 1.25rem; padding: 0; }
    .ai-rec ul { list-style: disc; }
    .ai-rec ol { list-style: decimal; }
    .ai-rec li { margin-bottom: 0.4rem; }
    .ai-rec li > ul, .ai-rec li > ol { margin-top: 0.4rem; margin-bottom: 0; }

    .ai-rec blockquote {
        border-left: 3px solid var(--accent, #f3b4b8);
        padding-left: 0.75rem;
        margin: 0.75rem 0;
        color: #6b7280;
        font-style: italic;
    }

    .ai-rec code {
        background: #f3f4f6;
        padding: 0.15rem 0.4rem;
        border-radius: 0.35rem;
        font-size: 0.8rem;
    }

    .ai-rec hr {
        border: none;
        border-top: 1px solid var(--line, #e5e7eb);
        margin: 1rem 0;
    }

    .ai-rec table {
        width: 100%;
        border-collapse: collapse;
        margin: 0.75rem 0;
        font-size: 0.8rem;
    }
    .ai-rec th, .ai-rec td {
        border: 1px solid var(--line, #e5e7eb);
        padding: 0.4rem 0.6rem;
        text-align: left;
    }

    /* ===== Fade + tombol toggle per kartu ===== */
    .ai-rec-fade {
        position: absolute;
        left: 1.25rem;
        right: 1.25rem;
        height: 2.25rem;
        margin-top: -2.25rem;
        background: linear-gradient(to bottom, rgba(255,255,255,0), #ffffff);
        pointer-events: none;
        transition: opacity 0.2s ease;
    }
    .ai-rec-fade.hidden { opacity: 0; }

    .ai-rec-toggle {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        margin-top: 0.75rem;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--accent, #e0656d);
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }
    .ai-rec-toggle svg { transition: transform 0.25s ease; }
    .ai-rec-toggle.expanded svg { transform: rotate(180deg); }
</style>

<script>
    (function () {
        document.querySelectorAll('.ai-sec-card').forEach(function (card) {
            const toggle = card.querySelector('.ai-rec-toggle');
            if (!toggle) return;

            const idx = toggle.dataset.target;
            const body = document.getElementById('aiSecBody' + idx);
            const fade = document.getElementById('aiSecFade' + idx);

            // Sembunyikan tombol & fade kalau konten pendek, tidak perlu di-collapse
            requestAnimationFrame(function () {
                if (body.scrollHeight <= body.clientHeight + 4) {
                    toggle.style.display = 'none';
                    if (fade) fade.classList.add('hidden');
                }
            });

            toggle.addEventListener('click', function () {
                const isExpanded = body.classList.toggle('expanded');
                toggle.classList.toggle('expanded', isExpanded);
                if (fade) fade.classList.toggle('hidden', isExpanded);
                toggle.childNodes[0].textContent = isExpanded ? 'Sembunyikan ' : 'Lihat selengkapnya ';
            });
        });
    })();
</script>

@endsection