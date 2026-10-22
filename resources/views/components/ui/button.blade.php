@props([
    'href' => null,
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
])

@php
    $variants = [
        'primary' => 'bg-emerald-700 text-white shadow-sm hover:bg-emerald-800 focus-visible:outline-emerald-700',
        'secondary' => 'border border-slate-300 bg-white text-slate-900 shadow-sm hover:bg-slate-50 focus-visible:outline-slate-500',
        'ghost' => 'text-slate-700 hover:bg-slate-100 focus-visible:outline-slate-500',
        'soft' => 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100 focus-visible:outline-emerald-700',
        'inverse' => 'border border-white/20 bg-white/10 text-white hover:bg-white/15 focus-visible:outline-white',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-5 py-3 text-base',
    ];

    $classes = 'inline-flex items-center justify-center gap-2 rounded-full font-semibold transition focus-visible:outline-2 focus-visible:outline-offset-2 disabled:pointer-events-none disabled:opacity-50 '
        .($variants[$variant] ?? $variants['primary']).' '
        .($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
