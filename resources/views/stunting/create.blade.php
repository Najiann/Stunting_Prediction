@extends('layouts.dashboard')

@section('page-title', 'Buat Prediksi Baru')
@section('page-subtitle', 'Isi data balita untuk mendapatkan hasil prediksi')

@section('header-action')
    <a href="{{ route('stunting.index') }}"
       class="btn-outline inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2.5 rounded-full">
        ← Riwayat
    </a>
@endsection

@section('content')

    <div class="max-w-3xl">

        @if ($errors->has('api'))
            <div class="rounded-2xl p-4 mb-6 text-sm flex items-start gap-3" style="background:var(--accent-soft); color:var(--dark-red)">
                <span class="text-lg">❌</span>
                <div>
                    <p class="font-semibold">Terjadi kesalahan</p>
                    <p>{{ $errors->first('api') }}</p>
                </div>
            </div>
        @endif

        <form action="{{ route('stunting.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Data Balita -->
            <div class="section-card">
                <div class="flex items-center gap-2 mb-5">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background:var(--accent-soft)">👶</span>
                    <h2 class="font-display font-bold">Data Balita</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="field-label">Nama Balita (opsional)</label>
                        <input type="text" name="nama_balita" value="{{ old('nama_balita') }}"
                               placeholder="Contoh: Kaelen Reis Cavascal"
                               class="input-field {{ $errors->has('nama_balita') ? 'error' : '' }}">
                        @error('nama_balita')<p class="field-error">⚠️ {{ $message }}</p>@enderror
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Usia (bulan) *</label>
                            <input type="number" name="usia_bulan" value="{{ old('usia_bulan') }}" min="0" max="60"
                                   placeholder="0 - 60 bulan"
                                   class="input-field {{ $errors->has('usia_bulan') ? 'error' : '' }}" required>
                            @error('usia_bulan')<p class="field-error">⚠️ Usia wajib diisi, antara 0 sampai 60 bulan.</p>@enderror
                        </div>
                        <div>
                            <label class="field-label">Jenis Kelamin *</label>
                            <select name="jenis_kelamin" class="input-field {{ $errors->has('jenis_kelamin') ? 'error' : '' }}" required>
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin')=='L'?'selected':'' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin')=='P'?'selected':'' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<p class="field-error">⚠️ Silakan pilih jenis kelamin balita.</p>@enderror
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Berat Lahir (kg) *</label>
                            <input type="number" step="0.01" name="berat_lahir_kg" value="{{ old('berat_lahir_kg') }}"
                                   placeholder="cth: 3.2"
                                   class="input-field {{ $errors->has('berat_lahir_kg') ? 'error' : '' }}" required>
                            @error('berat_lahir_kg')<p class="field-error">⚠️ Berat lahir wajib diisi dengan angka yang valid.</p>@enderror
                        </div>
                        <div>
                            <label class="field-label">Panjang Lahir (cm) *</label>
                            <input type="number" step="0.1" name="panjang_lahir_cm" value="{{ old('panjang_lahir_cm') }}"
                                   placeholder="cth: 50.0"
                                   class="input-field {{ $errors->has('panjang_lahir_cm') ? 'error' : '' }}" required>
                            @error('panjang_lahir_cm')<p class="field-error">⚠️ Panjang lahir wajib diisi dengan angka yang valid.</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nutrisi -->
            <div class="section-card">
                <div class="flex items-center gap-2 mb-5">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background:var(--accent-soft)">🍽️</span>
                    <h2 class="font-display font-bold">Nutrisi & Pola Makan</h2>
                </div>

                <div class="space-y-4">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">ASI Eksklusif *</label>
                            <select name="asi_eksklusif" class="input-field {{ $errors->has('asi_eksklusif') ? 'error' : '' }}" required>
                                <option value="">-- Pilih --</option>
                                <option value="Ya"    {{ old('asi_eksklusif')=='Ya'?'selected':'' }}>Ya</option>
                                <option value="Tidak" {{ old('asi_eksklusif')=='Tidak'?'selected':'' }}>Tidak</option>
                            </select>
                            @error('asi_eksklusif')<p class="field-error">⚠️ Silakan pilih status ASI eksklusif.</p>@enderror
                        </div>
                        <div>
                            <label class="field-label">Protein Harian (g) *</label>
                            <input type="number" step="0.1" name="protein_harian" value="{{ old('protein_harian') }}"
                                   placeholder="cth: 45.0"
                                   class="input-field {{ $errors->has('protein_harian') ? 'error' : '' }}" required>
                            @error('protein_harian')<p class="field-error">⚠️ Asupan protein harian wajib diisi.</p>@enderror
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Frekuensi Makan (x/hari) *</label>
                            <input type="number" name="frekuensi_makan" value="{{ old('frekuensi_makan') }}"
                                   placeholder="cth: 3"
                                   class="input-field {{ $errors->has('frekuensi_makan') ? 'error' : '' }}" required>
                            @error('frekuensi_makan')<p class="field-error">⚠️ Frekuensi makan wajib diisi.</p>@enderror
                        </div>
                        <div>
                            <label class="field-label">Tinggi Ibu (cm) *</label>
                            <input type="number" step="0.1" name="tinggi_ibu_cm" value="{{ old('tinggi_ibu_cm') }}"
                                   placeholder="cth: 160.0"
                                   class="input-field {{ $errors->has('tinggi_ibu_cm') ? 'error' : '' }}" required>
                            @error('tinggi_ibu_cm')<p class="field-error">⚠️ Tinggi badan ibu wajib diisi.</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lingkungan -->
            <div class="section-card">
                <div class="flex items-center gap-2 mb-5">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background:var(--accent-soft)">🏡</span>
                    <h2 class="font-display font-bold">Lingkungan & Riwayat Kesehatan</h2>
                </div>

                <div class="space-y-4">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Riwayat Diare (kali) *</label>
                            <input type="number" name="riwayat_diare" value="{{ old('riwayat_diare') }}"
                                   placeholder="cth: 1"
                                   class="input-field {{ $errors->has('riwayat_diare') ? 'error' : '' }}" required>
                            @error('riwayat_diare')<p class="field-error">⚠️ Jumlah riwayat diare wajib diisi.</p>@enderror
                        </div>
                        <div>
                            <label class="field-label">Pendapatan Keluarga (Rp) *</label>
                            <input type="number" name="pendapatan_keluarga" value="{{ old('pendapatan_keluarga') }}"
                                   placeholder="cth: 6000000"
                                   class="input-field {{ $errors->has('pendapatan_keluarga') ? 'error' : '' }}" required>
                            @error('pendapatan_keluarga')<p class="field-error">⚠️ Pendapatan keluarga wajib diisi.</p>@enderror
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Sanitasi Layak *</label>
                            <select name="sanitasi_layak" class="input-field {{ $errors->has('sanitasi_layak') ? 'error' : '' }}" required>
                                <option value="">-- Pilih --</option>
                                <option value="Ya"    {{ old('sanitasi_layak')=='Ya'?'selected':'' }}>Ya</option>
                                <option value="Tidak" {{ old('sanitasi_layak')=='Tidak'?'selected':'' }}>Tidak</option>
                            </select>
                            @error('sanitasi_layak')<p class="field-error">⚠️ Silakan pilih status sanitasi.</p>@enderror
                        </div>
                        <div>
                            <label class="field-label">Imunisasi Lengkap *</label>
                            <select name="imunisasi_lengkap" class="input-field {{ $errors->has('imunisasi_lengkap') ? 'error' : '' }}" required>
                                <option value="">-- Pilih --</option>
                                <option value="Ya"    {{ old('imunisasi_lengkap')=='Ya'?'selected':'' }}>Ya</option>
                                <option value="Tidak" {{ old('imunisasi_lengkap')=='Tidak'?'selected':'' }}>Tidak</option>
                            </select>
                            @error('imunisasi_lengkap')<p class="field-error">⚠️ Silakan pilih status imunisasi.</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit"
                    class="btn-primary group w-full relative overflow-hidden text-white font-bold py-3.5 rounded-2xl text-sm">
                <span class="relative z-10 flex items-center justify-center gap-2">
                    🔍 Prediksi Sekarang
                </span>
            </button>
        </form>
    </div>

@endsection