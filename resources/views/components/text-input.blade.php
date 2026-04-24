@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['style' => 'background:var(--color-dark-700); border:1px solid var(--color-dark-500); color:white; outline:none; border-radius:0.5rem; padding:0.625rem 0.875rem; width:100%;', 'class' => 'focus:ring focus:ring-orange-500/50 focus:border-orange-500']) }}>
