<x-guest-layout>
    <h1 class="font-display font-bold text-2xl mb-1">Lupa Password?</h1>
    <p class="text-sm mb-6 leading-relaxed" style="color:var(--muted)">
        Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan link untuk membuat password baru.
    </p>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1.5" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full mt-2">
            Kirim Link Reset Password
        </x-primary-button>

        <p class="text-center text-sm pt-2" style="color:var(--muted)">
            Ingat password Anda?
            <a href="{{ route('login') }}" class="font-semibold" style="color:var(--dark-red)">Kembali masuk</a>
        </p>
    </form>
</x-guest-layout>