<x-guest-layout>
    <h1 class="font-display font-bold text-2xl mb-1">Masuk ke Akun</h1>
    <p class="text-sm mb-6" style="color:var(--muted)">Pantau riwayat prediksi stunting balita Anda</p>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1.5" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1.5"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm cursor-pointer" style="color:var(--muted)">
                <input id="remember_me" type="checkbox" class="rounded" name="remember">
                Ingat saya
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold link-muted" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <x-primary-button class="w-full mt-2">
            Masuk
        </x-primary-button>

        <p class="text-center text-sm pt-2" style="color:var(--muted)">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold" style="color:var(--dark-red)">Daftar di sini</a>
        </p>
    </form>
</x-guest-layout>