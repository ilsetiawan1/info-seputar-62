@props(['value'])

<label {{ $attributes->merge(['style' => 'display:block; font-weight:600; font-size:0.875rem; color:var(--color-dark-100); margin-bottom:0.25rem;']) }}>
    {{ $value ?? $slot }}
</label>
