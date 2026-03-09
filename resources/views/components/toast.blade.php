@props([
    'type' => 'info',
    'duration' => 3000
])

@php
    $configs = [
        'info' => [
            'bg' => 'bg-surface',
            'border' => 'border-[#bfdbfe]',
            'icon_color' => 'text-[#3b82f6]',
            'icon' => '<circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>'
        ],
        'success' => [
            'bg' => 'bg-surface',
            'border' => 'border-[#bbf7d0]',
            'icon_color' => 'text-[#22c55e]',
            'icon' => '<path d="M20 7l-8 8-4-4"/>'
        ],
        'warning' => [
            'bg' => 'bg-surface',
            'border' => 'border-[#fde68a]',
            'icon_color' => 'text-[#f59e0b]',
            'icon' => '<path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>'
        ],
        'error' => [
            'bg' => 'bg-surface',
            'border' => 'border-[#fecdd3]',
            'icon_color' => 'text-[#e11d48]',
            'icon' => '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'
        ]
    ][$type] ?? $configs['info'];
@endphp

<div 
    x-data="{ show: false, message: '', timer: null }"
    x-show="show"
    x-on:notify.window="
        message = $event.detail.message;
        if ($event.detail.type === @js($type) || (!$event.detail.type && @js($type) === 'info')) {
            show = true;
            clearTimeout(timer);
            timer = setTimeout(() => show = false, @js($duration));
        }
    "
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-8"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-8"
    class="fixed top-6 right-6 z-[100000] w-full max-w-[380px] p-4 bg-surface rounded-[14px] shadow-[0_10px_30px_rgba(0,0,0,0.12)] border {{ $configs['border'] }} overflow-hidden"
    style="display: none;"
>
    <div class="flex gap-3 items-start">
        <div class="w-9 h-9 rounded-[10px] {{ $configs['bg'] }} border {{ $configs['border'] }} flex items-center justify-center shrink-0">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" class="{{ $configs['icon_color'] }}">
                {!! $configs['icon'] !!}
            </svg>
        </div>
        <div class="flex-1 pt-0.5">
            <p x-text="message" class="text-[13px] font-semibold text-text leading-relaxed"></p>
        </div>
        <button @click="show = false" class="bg-none border-none p-1 text-muted-light cursor-pointer opacity-60 transition-opacity duration-200 hover:opacity-100">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>
    
    <!-- Progress Bar -->
    <div class="absolute bottom-0 left-0 h-[3px] opacity-15 transition-[width] ease-linear bg-current {{ $configs['icon_color'] }}" :style="{ width: show ? '100%' : '0%', transitionDuration: show ? @js($duration) + 'ms' : '0ms' }"></div>
</div>
