@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => true
])
@php
    $configs = [
        'info' => [
            'bg' => 'bg-[#eff6ff]',
            'border' => 'border-[#bfdbfe]',
            'icon_color' => 'text-[#3b82f6]',
            'title_color' => 'text-[#1d4ed8]',
            'text_color' => 'text-[#3b82f6]',
            'icon' => '<circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>'
        ],
        'success' => [
            'bg' => 'bg-brand-light',
            'border' => 'border-[#bbf7d0]',
            'icon_color' => 'text-[#22c55e]',
            'title_color' => 'text-[#166534]',
            'text_color' => 'text-[#16a34a]',
            'icon' => '<path d="M20 7l-8 8-4-4"/>'
        ],
        'warning' => [
            'bg' => 'bg-[#fffbeb]',
            'border' => 'border-[#fde68a]',
            'icon_color' => 'text-[#f59e0b]',
            'title_color' => 'text-[#92400e]',
            'text_color' => 'text-[#d97706]',
            'icon' => '<path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>'
        ],
        'error' => [
            'bg' => 'bg-[#fff1f2]',
            'border' => 'border-[#fecdd3]',
            'icon_color' => 'text-[#e11d48]',
            'title_color' => 'text-[#9f1239]',
            'text_color' => 'text-[#e11d48]',
            'icon' => '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'
        ]
    ][$type] ?? $configs['info'];
@endphp
<div 
 x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"

           class="flex gap-3 p-[14px_16px] rounded-[14px] {{ $configs['bg'] }} border {{ $configs['border'] }} relative"
>
    <!-- Icon -->
    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="shrink-0 mt-0.5 {{ $configs['icon_color'] }}">
        {!! $configs['icon'] !!}
    </svg>
    <!-- Content -->
    <div class="flex-1">
        @if($title)
            <p class="text-[14px] font-bold {{ $configs['title_color'] }} mb-0.5">{{ $title }}</p>
        @endif
        <div class="text-[13px] {{ $configs['text_color'] }} leading-relaxed">
            {{ $slot }}
        </div>
</div>

       
             
        <!-- Dismiss Button -->
    @if($dismissible)
        <button @click="show = false" class="bg-none border-none p-1 transition-opacity duration-200 opacity-70 hover:opacity-100 cursor-pointer {{ $configs['icon_color'] }}">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    @endif
</div>
