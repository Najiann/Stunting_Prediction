@props(['type' => 'submit'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn-primary inline-flex items-center justify-center gap-2 text-white font-semibold text-sm px-6 py-3 rounded-xl']) }}>
    {{ $slot }}
</button>