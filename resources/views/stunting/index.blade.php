@extends('layouts.dashboard')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Semua hasil skrining stunting balita Anda')

@section('header-action')
    <a href="{{ route('stunting.create') }}"
       class="btn-primary inline-flex items-center gap-2 text-white font-semibold text-sm px-5 py-2.5 rounded-full">
        <span class="text-base leading-none">+</span> Tambah Data
    </a>
@endsection

@section('content')

    @if(session('success'))
        <div class="rounded-2xl p-4 mb-6 text-sm flex items-center gap-2" style="background:var(--success-soft); color:var(--success)">
            ✓ {{ session('success') }}
        </div>
    @endif

    <!-- STAT CARDS -->
    <div class="grid sm:grid-cols-3 gap-4 mb-8">
        <div class="section-card">
            <p class="text-xs font-semibold uppercase tracking-wide" style="color:var(--muted)">Total Prediksi</p>
            <p class="font-mono font-bold text-2xl mt-1.5">{{ $totalAll }}</p>
        </div>
        <div class="section-card">
            <p class="text-xs font-semibold uppercase tracking-wide" style="color:var(--muted)">Terindikasi Stunting</p>
            <p class="font-mono font-bold text-2xl mt-1.5" style="color:var(--accent)">{{ $totalStunting }}</p>
        </div>
        <div class="section-card">
            <p class="text-xs font-semibold uppercase tracking-wide" style="color:var(--muted)">Normal</p>
            <p class="font-mono font-bold text-2xl mt-1.5" style="color:var(--success)">{{ $totalNormal }}</p>
        </div>
    </div>

    <!-- SEARCH & FILTER -->
    <form method="GET" action="{{ route('stunting.index') }}"
          class="bg-white rounded-2xl border p-4 mb-6 flex flex-col sm:flex-row gap-3" style="border-color:var(--line)">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama balita..."
                   class="input-field">
        </div>
        <div class="sm:w-56">
            <select name="status" class="input-field">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Stunting</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tidak Stunting</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit"
                    class="btn-primary text-white font-semibold text-sm px-5 py-2.5 rounded-xl whitespace-nowrap">
                Cari
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('stunting.index') }}"
                   class="btn-outline flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl border overflow-hidden" style="border-color:var(--line)">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b" style="border-color:var(--line); background:var(--bg-soft)">
                        <th class="text-left px-6 py-4 font-semibold text-xs uppercase tracking-wide" style="color:var(--muted)">Nama Balita</th>
                        <th class="text-left px-6 py-4 font-semibold text-xs uppercase tracking-wide" style="color:var(--muted)">Usia (Bulan)</th>
                        <th class="text-left px-6 py-4 font-semibold text-xs uppercase tracking-wide" style="color:var(--muted)">Jenis Kelamin</th>
                        <th class="text-left px-6 py-4 font-semibold text-xs uppercase tracking-wide" style="color:var(--muted)">Hasil Prediksi</th>
                        <th class="text-left px-6 py-4 font-semibold text-xs uppercase tracking-wide" style="color:var(--muted)">Tanggal Cek</th>
                        <th class="text-left px-6 py-4 font-semibold text-xs uppercase tracking-wide" style="color:var(--muted)">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color:var(--line)">
                    @forelse($predictions as $p)
                    <tr class="row-hover transition-colors">
                        <td class="px-6 py-4 font-semibold">{{ $p->nama_balita ?? '-' }}</td>
                        <td class="px-6 py-4" style="color:var(--muted)">{{ $p->usia_bulan }} bln</td>
                        <td class="px-6 py-4" style="color:var(--muted)">{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="px-6 py-4">
                            @if($p->prediction_code == 1)
                                <span class="badge" style="background:var(--accent-soft); color:var(--dark-red)">⚠ STUNTING</span>
                            @else
                                <span class="badge" style="background:var(--success-soft); color:var(--success)">✓ TIDAK STUNTING</span>
                            @endif
                        </td>
                        <td class="px-6 py-4" style="color:var(--muted)">{{ $p->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('stunting.show', $p->id) }}" class="text-xs font-semibold hover:underline" style="color:var(--accent)">
                                Lihat Detail →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center" style="color:var(--muted)">
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-3xl">📭</span>
                                <span class="text-sm">
                                    @if(request('search') || request('status'))
                                        Tidak ada data yang cocok dengan pencarian/filter ini.
                                    @else
                                        Belum ada data prediksi.
                                    @endif
                                </span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5 pagination-theme">
        {{ $predictions->links() }}
    </div>

@endsection