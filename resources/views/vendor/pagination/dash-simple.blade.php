@if ($paginator->hasPages())
    <div style="display:flex;align-items:center;justify-content:space-between;width:100%;flex-wrap:wrap;gap:12px;padding:4px 5px;">
        <div style="font-size:12.5px;color:var(--muted);font-weight:500;">
            Menampilkan <span style="font-weight:800;color:var(--text);background:var(--bg);padding:2px 8px;border-radius:8px;margin:0 2px;">{{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}</span> 
            dari <span style="font-weight:800;color:var(--brand);">{{ $paginator->total() }}</span> entri
        </div>
        
        <div style="display:flex;gap:10px;">
            @if ($paginator->onFirstPage())
                <button class="btn btn-sm" disabled style="background:var(--bg);color:var(--muted-light);border-radius:20px;padding:8px 16px;opacity:0.6;cursor:not-allowed;font-weight:700;">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" style="margin-right:6px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Prev
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm btn-secondary" 
                   style="border-radius:20px;padding:8px 16px;text-decoration:none;font-weight:700;transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);display:inline-flex;align-items:center;background:var(--bg);border:1.5px solid var(--border);"
                   onmouseover="this.style.transform='translateX(-3px)';this.style.borderColor='var(--brand)';this.style.color='var(--brand)'"
                   onmouseout="this.style.transform='translateX(0)';this.style.borderColor='var(--border)';this.style.color='var(--muted)'">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" style="margin-right:6px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Prev
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm btn-secondary"
                   style="border-radius:20px;padding:8px 16px;text-decoration:none;font-weight:700;transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);display:inline-flex;align-items:center;background:var(--bg);border:1.5px solid var(--border);"
                   onmouseover="this.style.transform='translateX(3px)';this.style.borderColor='var(--brand)';this.style.color='var(--brand)'"
                   onmouseout="this.style.transform='translateX(0)';this.style.borderColor='var(--border)';this.style.color='var(--muted)'">
                    Next
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" style="margin-left:6px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <button class="btn btn-sm" disabled style="background:var(--bg);color:var(--muted-light);border-radius:20px;padding:8px 16px;opacity:0.6;cursor:not-allowed;font-weight:700;">
                    Next
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" style="margin-left:6px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            @endif
        </div>
    </div>
@endif