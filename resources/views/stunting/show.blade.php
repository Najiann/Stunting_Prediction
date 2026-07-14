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
    $isStunting = $stunting->prediction_code == 1;
    $percent = $stunting->probability_stunting_percent !== null ? round($stunting->probability_stunting_percent, 1) : null;
    $circumference = 2 * pi() * 54;
    $offset = $percent !== null ? $circumference - ($percent / 100) * $circumference : $circumference;
    $namaSebut = $stunting->nama_balita ?: 'balita ini';

    // --- Rekomendasi ---
    $recs = [];

    // Fase MPASI berdasarkan usia
    if ($stunting->usia_bulan < 6) {
        $recs[] = ['🤱', "Usia {$namaSebut} masih {$stunting->usia_bulan} bulan, fokuskan ASI eksklusif tanpa makanan/minuman tambahan hingga genap 6 bulan."];
    } elseif ($stunting->usia_bulan < 9) {
        $recs[] = ['🥣', "Di usia {$stunting->usia_bulan} bulan, berikan MPASI bertekstur halus/lumat (bubur saring, puree) 2-3x sehari."];
    } elseif ($stunting->usia_bulan < 12) {
        $recs[] = ['🥣', "Di usia {$stunting->usia_bulan} bulan, naikkan tekstur MPASI jadi cincang halus dan mulai kenalkan finger food."];
    } elseif ($stunting->usia_bulan < 24) {
        $recs[] = ['🍛', "Di usia {$stunting->usia_bulan} bulan, {$namaSebut} sudah bisa makan makanan keluarga yang dicincang/dipotong kecil, 3x makan utama + 2x selingan."];
    } else {
        $recs[] = ['🍽️', "Di usia {$stunting->usia_bulan} bulan, berikan porsi makan mendekati porsi dewasa (ukuran lebih kecil) dengan menu bervariasi tiap hari."];
    }

    // ASI eksklusif
    if ($stunting->asi_eksklusif === 'Tidak' && $stunting->usia_bulan < 6) {
        $recs[] = ['🍼', "ASI belum diberikan secara eksklusif! sebaiknya kembali fokus ke ASI eksklusif dulu sebelum menambah makanan lain."];
    } elseif ($stunting->asi_eksklusif === 'Ya') {
        $recs[] = ['👍', "Riwayat ASI eksklusif {$namaSebut} sudah baik, lanjutkan pemberian ASI hingga usia 2 tahun didampingi MPASI."];
    }

    // Protein harian aktual
    if ($stunting->protein_harian < 30) {
        $target = round(max(30, $stunting->protein_harian + 15));
        $recs[] = ['🍗', "Asupan protein harian saat ini {$stunting->protein_harian} g tergolong rendah! naikkan bertahap ke sekitar {$target} g/hari lewat telur, ikan, ayam, hati, tempe, atau tahu."];
    } else {
        $recs[] = ['✅', "Asupan protein harian {$stunting->protein_harian} g sudah cukup baik, pertahankan variasi sumber protein hewani & nabati."];
    }

    // Frekuensi makan aktual
    if ($stunting->frekuensi_makan < 3) {
        $recs[] = ['⏰', "Frekuensi makan saat ini {$stunting->frekuensi_makan}x/hari! tingkatkan jadi minimal 3x makan utama ditambah 1-2x selingan sehat."];
    }

    // Riwayat diare aktual
    if ($stunting->riwayat_diare >= 3) {
        $recs[] = ['💧', "Riwayat diare tercatat {$stunting->riwayat_diare} kali (cukup sering)! perhatikan kebersihan air minum, cuci tangan, dan kebersihan alat makan."];
    } elseif ($stunting->riwayat_diare >= 1) {
        $recs[] = ['💧', "Ada riwayat diare {$stunting->riwayat_diare} kali! tetap jaga kebersihan makanan dan air minum agar tidak berulang."];
    }

    // Sanitasi
    if ($stunting->sanitasi_layak === 'Tidak') {
        $recs[] = ['🚰', 'Akses sanitasi di lingkungan rumah belum layak! prioritaskan perbaikan sumber air bersih & jamban sehat, koordinasikan dengan kader Posyandu setempat.'];
    }

    // Imunisasi
    if ($stunting->imunisasi_lengkap === 'Tidak') {
        $recs[] = ['💉', "Imunisasi belum lengkap, segera lengkapi ke Puskesmas terdekat agar daya tahan tubuh {$namaSebut} lebih optimal."];
    } else {
        $recs[] = ['💉', 'Imunisasi sudah lengkap, teruskan sesuai jadwal booster berikutnya.'];
    }

    // Penutup sesuai hasil prediksi
    $recs[] = $isStunting
        ? ['🏥', 'Segera lakukan konseling gizi ke Puskesmas atau kader Posyandu terdekat untuk penanganan lebih lanjut.']
        : ['📈', 'Tetap pantau berat & tinggi badan setiap bulan di Posyandu untuk memastikan pertumbuhan tetap pada jalurnya.'];
@endphp

<div class="max-w-5xl">
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

            <div class="section-card">
                <div class="flex items-center gap-2 mb-4">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm shrink-0" style="background:var(--accent-soft)">
                        {{ $isStunting ? '🥣' : '🌱' }}
                    </span>
                    <h3 class="font-display font-bold">Rekomendasi Tindakan & MPASI</h3>
                </div>

                <ul class="space-y-3 text-sm" style="color:var(--muted)">
                    @foreach($recs as [$icon, $text])
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 shrink-0">{{ $icon }}</span>
                            <span>{{ $text }}</span>
                        </li>
                    @endforeach
                </ul>
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
</div>

@endsection