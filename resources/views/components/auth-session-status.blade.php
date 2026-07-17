@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'status-box']) }}>
        <span>✓</span>
        <span>{{ $status }}</span>
    </div>
@endif