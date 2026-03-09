@props([
    'id', 
    'title' => null, 
    'size' => 'md',
    'show' => false
])

@php
    $sizeClasses = [
        'sm' => 'max-width: 400px;',
        'md' => 'max-width: 540px;',
        'lg' => 'max-width: 800px;',
        'xl' => 'max-width: 1140px;',
        'full' => 'max-width: 95%;',
    ][$size] ?? 'max-width: 540px;';
@endphp

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-on:open-modal-{{ $id }}.window="show = true"
    x-on:close-modal-{{ $id }}.window="show = false"
    x-on:keydown.escape.window="show = false"
    style="display: none; position: fixed; inset: 0; z-index: 100000;"
    role="dialog"
    aria-modal="true"
>
    <!-- Overlay with centering -->
    <div 
        x-show="show"
        class="modal-overlay"
        @click="show = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >

    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        style="position: relative; width: 90%; {{ $sizeClasses }} background: var(--surface); border-radius: 32px; box-shadow: var(--shadow-hover); border: 1px solid var(--border); overflow: hidden; z-index: 100001;"
    >
        @if($title || $slot->hasActualContent() || isset($header))
            <div style="padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
                <div>
                    @if($title)
                        <h3 style="font-size: 17px; font-weight: 800; color: var(--text); letter-spacing: -0.02em;">{{ $title }}</h3>
                    @endif
                    @isset($header)
                        {{ $header }}
                    @endisset
                </div>
                <button @click="show = false" class="btn btn-icon btn-secondary" style="padding: 6px; border-radius: 8px;">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        <div style="padding: 22px;">
            {{ $slot }}
        </div>

        @isset($footer)
            <div style="padding: 16px 22px; background: var(--bg); border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px;">
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>
