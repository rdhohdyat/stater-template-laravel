@props([
    'id',
    'type' => 'success',
    'title' => null,
    'show' => false
])

@php
    $configs = [
        'success' => [
            'icon_bg' => 'bg-[#dcfce7]',
            'icon_color' => 'text-[#16a34a]',
            'icon' => '<path d="M20 7l-8 8-4-4"/>'
        ],
        'error' => [
            'icon_bg' => 'bg-[#ffe4e6]',
            'icon_color' => 'text-[#e11d48]',
            'icon' => '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'
        ],
        'warning' => [
            'icon_bg' => 'bg-[#fef3c7]',
            'icon_color' => 'text-[#d97706]',
            'icon' => '<path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>'
        ],
        'info' => [
            'icon_bg' => 'bg-[#dbeafe]',
            'icon_color' => 'text-[#2563eb]',
            'icon' => '<circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>'
        ]
    ][$type] ?? $configs['success'];
@endphp

<template x-teleport="body">
    <div
        x-data="{ show: @js($show) }"
        x-show="show"
        x-init="$watch('show', val => { if(val) document.body.style.overflow = 'hidden'; else document.body.style.overflow = ''; })"
        x-on:open-alert-{{ $id }}.window="show = true"
        x-on:close-alert-{{ $id }}.window="show = false"
        x-on:keydown.escape.window="show = false"
        class="fixed inset-0 z-[100000] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
        style="display: none;"
    >
        <div 
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            class="relative w-full max-w-[400px] bg-surface rounded-[32px] shadow-hover border border-border p-8 text-center z-[100001]"
            @click.outside="show = false"
        >
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5 {{ $configs['icon_bg'] }}">
                <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" class="{{ $configs['icon_color'] }}">
                    {!! $configs['icon'] !!}
                </svg>
            </div>

            @if($title)
                <h3 class="text-xl font-extrabold text-text tracking-tight mb-2.5">{{ $title }}</h3>
            @endif

            <div class="text-[14px] text-muted leading-relaxed mb-7">
                {{ $slot }}
            </div>

            <div class="flex flex-col gap-2.5">
                @isset($actions)
                    {{ $actions }}
                @else
                    <button @click="show = false" class="btn btn-primary w-full justify-center">OK, Got it</button>
                @endisset
            </div>
        </div>
    </div>
</template>
