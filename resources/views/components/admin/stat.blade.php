@props([
    'label',
    'value',
    'hint' => null,
    'tone' => 'emerald',
])

@php
    $tones = [
        'emerald' => 'bg-emerald-500',
        'amber' => 'bg-amber-500',
        'slate' => 'bg-slate-500',
        'rose' => 'bg-rose-500',
    ];
@endphp

<article {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm']) }}>
    <span class="absolute inset-x-0 top-0 h-1 {{ $tones[$tone] ?? $tones['emerald'] }}"></span>
    <p class="text-sm text-slate-600">{{ $label }}</p>
    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-950">{{ $value }}</p>

    @if ($hint)
        <p class="mt-2 text-xs text-slate-500">{{ $hint }}</p>
    @endif
</article>
