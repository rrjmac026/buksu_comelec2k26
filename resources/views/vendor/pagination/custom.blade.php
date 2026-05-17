@if ($paginator->hasPages())
<nav style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">

    {{-- Info --}}
    <div style="font-size:0.68rem; color:rgba(255,251,240,0.35); font-family:'DM Sans',sans-serif;">
        Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}
        of {{ $paginator->total() }} candidates
    </div>

    {{-- Links --}}
    <div style="display:flex; align-items:center; gap:4px;">

        {{-- Prev --}}
        @if($paginator->onFirstPage())
            <span style="min-width:32px;height:32px;padding:0 8px;border-radius:8px;
                         border:1px solid rgba(249,180,15,0.15);background:transparent;
                         color:rgba(249,180,15,0.2);font-family:'DM Sans',sans-serif;
                         font-size:0.72rem;font-weight:600;display:inline-flex;
                         align-items:center;justify-content:center;cursor:not-allowed;opacity:0.3;">
                <i class="fas fa-chevron-left" style="font-size:.55rem;"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               style="min-width:32px;height:32px;padding:0 8px;border-radius:8px;
                      border:1px solid rgba(249,180,15,0.15);background:transparent;
                      color:rgba(249,180,15,0.55);font-family:'DM Sans',sans-serif;
                      font-size:0.72rem;font-weight:600;display:inline-flex;
                      align-items:center;justify-content:center;text-decoration:none;
                      transition:all .18s;"
               onmouseover="this.style.background='rgba(249,180,15,0.08)';this.style.borderColor='rgba(249,180,15,0.35)';this.style.color='#f9b40f';"
               onmouseout="this.style.background='transparent';this.style.borderColor='rgba(249,180,15,0.15)';this.style.color='rgba(249,180,15,0.55)';">
                <i class="fas fa-chevron-left" style="font-size:.55rem;"></i>
            </a>
        @endif

        {{-- Page Numbers --}}
        @php
            $current  = $paginator->currentPage();
            $last     = $paginator->lastPage();
            $start    = max(1, $current - 2);
            $end      = min($last, $current + 2);
        @endphp

        @if($start > 1)
            <a href="{{ $paginator->url(1) }}"
               style="min-width:32px;height:32px;padding:0 8px;border-radius:8px;
                      border:1px solid rgba(249,180,15,0.15);background:transparent;
                      color:rgba(249,180,15,0.55);font-family:'DM Sans',sans-serif;
                      font-size:0.72rem;font-weight:600;display:inline-flex;
                      align-items:center;justify-content:center;text-decoration:none;transition:all .18s;"
               onmouseover="this.style.background='rgba(249,180,15,0.08)';this.style.borderColor='rgba(249,180,15,0.35)';this.style.color='#f9b40f';"
               onmouseout="this.style.background='transparent';this.style.borderColor='rgba(249,180,15,0.15)';this.style.color='rgba(249,180,15,0.55)';">1</a>
            @if($start > 2)
                <span style="color:rgba(249,180,15,0.3);font-size:0.7rem;padding:0 4px;">…</span>
            @endif
        @endif

        @for($p = $start; $p <= $end; $p++)
            @if($p == $current)
                <span style="min-width:32px;height:32px;padding:0 8px;border-radius:8px;
                             background:linear-gradient(135deg,#f9b40f,#fcd558);
                             border:1px solid transparent;color:#380041;
                             font-family:'DM Sans',sans-serif;font-size:0.72rem;font-weight:700;
                             display:inline-flex;align-items:center;justify-content:center;
                             box-shadow:0 2px 8px rgba(249,180,15,0.35);">
                    {{ $p }}
                </span>
            @else
                <a href="{{ $paginator->url($p) }}"
                   style="min-width:32px;height:32px;padding:0 8px;border-radius:8px;
                          border:1px solid rgba(249,180,15,0.15);background:transparent;
                          color:rgba(249,180,15,0.55);font-family:'DM Sans',sans-serif;
                          font-size:0.72rem;font-weight:600;display:inline-flex;
                          align-items:center;justify-content:center;text-decoration:none;transition:all .18s;"
                   onmouseover="this.style.background='rgba(249,180,15,0.08)';this.style.borderColor='rgba(249,180,15,0.35)';this.style.color='#f9b40f';"
                   onmouseout="this.style.background='transparent';this.style.borderColor='rgba(249,180,15,0.15)';this.style.color='rgba(249,180,15,0.55)';">
                    {{ $p }}
                </a>
            @endif
        @endfor

        @if($end < $last)
            @if($end < $last - 1)
                <span style="color:rgba(249,180,15,0.3);font-size:0.7rem;padding:0 4px;">…</span>
            @endif
            <a href="{{ $paginator->url($last) }}"
               style="min-width:32px;height:32px;padding:0 8px;border-radius:8px;
                      border:1px solid rgba(249,180,15,0.15);background:transparent;
                      color:rgba(249,180,15,0.55);font-family:'DM Sans',sans-serif;
                      font-size:0.72rem;font-weight:600;display:inline-flex;
                      align-items:center;justify-content:center;text-decoration:none;transition:all .18s;"
               onmouseover="this.style.background='rgba(249,180,15,0.08)';this.style.borderColor='rgba(249,180,15,0.35)';this.style.color='#f9b40f';"
               onmouseout="this.style.background='transparent';this.style.borderColor='rgba(249,180,15,0.15)';this.style.color='rgba(249,180,15,0.55)';">{{ $last }}</a>
        @endif

        {{-- Next --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               style="min-width:32px;height:32px;padding:0 8px;border-radius:8px;
                      border:1px solid rgba(249,180,15,0.15);background:transparent;
                      color:rgba(249,180,15,0.55);font-family:'DM Sans',sans-serif;
                      font-size:0.72rem;font-weight:600;display:inline-flex;
                      align-items:center;justify-content:center;text-decoration:none;transition:all .18s;"
               onmouseover="this.style.background='rgba(249,180,15,0.08)';this.style.borderColor='rgba(249,180,15,0.35)';this.style.color='#f9b40f';"
               onmouseout="this.style.background='transparent';this.style.borderColor='rgba(249,180,15,0.15)';this.style.color='rgba(249,180,15,0.55)';">
                <i class="fas fa-chevron-right" style="font-size:.55rem;"></i>
            </a>
        @else
            <span style="min-width:32px;height:32px;padding:0 8px;border-radius:8px;
                         border:1px solid rgba(249,180,15,0.15);background:transparent;
                         color:rgba(249,180,15,0.2);font-family:'DM Sans',sans-serif;
                         font-size:0.72rem;display:inline-flex;
                         align-items:center;justify-content:center;cursor:not-allowed;opacity:0.3;">
                <i class="fas fa-chevron-right" style="font-size:.55rem;"></i>
            </span>
        @endif

    </div>
</nav>
@endif