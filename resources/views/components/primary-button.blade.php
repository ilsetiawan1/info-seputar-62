<button {{ $attributes->merge(['type' => 'submit', 'style' => 'display:inline-flex; align-items:center; padding:0.5625rem 1.125rem; background:var(--color-brand-500); border:none; border-radius:0.5rem; font-weight:600; font-size:0.875rem; color:white; letter-spacing:0.05em; transition:all 0.2s;', 'onmouseover' => 'this.style.background="var(--color-brand-600)"', 'onmouseout' => 'this.style.background="var(--color-brand-500)"']) }}>
    {{ $slot }}
</button>
