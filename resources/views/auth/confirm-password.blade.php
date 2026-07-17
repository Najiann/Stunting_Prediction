<x-guest-layout>
    <h1 class="font-display font-bold text-2xl mb-1">Konfirmasi Password</h1>
    <p class="text-sm mb-6 leading-relaxed" style="color:var(--muted)">
        Ini adalah area aman pada aplikasi. Mohon konfirmasi password Anda sebelum melanjutkan.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1.5"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-primary-button class="w-full mt-2">
            Konfirmasi
        </x-primary-button>
    </form>
</x-guest-layout>