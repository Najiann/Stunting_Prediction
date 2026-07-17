<x-guest-layout>
    <h1 class="font-display font-bold text-2xl mb-1">Verifikasi Email Anda</h1>
    <p class="text-sm mb-5 leading-relaxed" style="color:var(--muted)">
        Terima kasih sudah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan. Belum menerima emailnya? Kami akan dengan senang hati mengirimkan yang baru.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="status-box mb-5">
            <span>✓</span>
            <span>Link verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.</span>
        </div>
    @endif

    <div class="flex items-center justify-between gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                Kirim Ulang Email Verifikasi
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm font-semibold link-muted">
                Keluar
            </button>
        </form>
    </div>
</x-guest-layout>