@php
    $cUrl = menuUrl($children->url);
    $isExt = isExternalUrl($children->url);
    $hasSub = $children->children && $children->children->count() > 0;
    $isRight = !empty($isRightSide);

    // Active check for this child or its subchildren
    $currentPath = trim(request()->path(), '/');
    $isChildActive = false;
    if ($children->url && $children->url !== '#' && $children->url !== 'javascript:void(0)') {
        $cleanChildUrl = trim(str_replace(url(''), '', $cUrl), '/');
        $isChildActive = ($currentPath === $cleanChildUrl) || (strlen($cleanChildUrl) > 2 && str_starts_with($currentPath, $cleanChildUrl));
    }
    if (!$isChildActive && $hasSub) {
        foreach ($children->children as $sub) {
            $subClean = trim(str_replace(url(''), '', menuUrl($sub->url)), '/');
            if ($subClean && $subClean !== '#' && ($currentPath === $subClean || (strlen($subClean) > 2 && str_starts_with($currentPath, $subClean)))) {
                $isChildActive = true;
                break;
            }
        }
    }
@endphp

@if ($hasSub)
    <div class="relative group/sub px-1">
        <a href="{{ $cUrl }}" 
           {!! $isExt ? 'target="_blank" rel="noopener"' : '' !!}
           class="bappeda-sub-parent flex items-center justify-between px-3 py-2 text-xs font-semibold rounded-lg transition no-underline text-decoration-none {{ $isChildActive ? 'is-active' : '' }}"
           style="color: {{ $isChildActive ? '#1A56DB' : '#334155' }} !important; background-color: {{ $isChildActive ? '#eff6ff' : 'transparent' }} !important;">
            <span class="truncate pr-2" style="color: inherit !important;">{{ $children->name }}</span>
            <i class="fas {{ $isRight ? 'fa-chevron-left' : 'fa-chevron-right' }} text-[9px] flex-shrink-0 transition-colors" style="color: {{ $isChildActive ? '#1A56DB' : '#94a3b8' }} !important;"></i>
        </a>
        <div class="absolute {{ $isRight ? 'right-full pr-1.5' : 'left-full pl-1.5' }} top-0 hidden group-hover/sub:block z-50">
            <div class="w-64 bg-white rounded-xl shadow-2xl border border-slate-100 py-1.5 divide-y divide-slate-50 text-left bappeda-dropdown-menu" style="background-color: #ffffff !important;">
                @foreach ($children->children as $subchild)
                    @include(getTheme('partials.menus_child'), ['children' => $subchild, 'isRightSide' => $isRight])
                @endforeach
            </div>
        </div>
    </div>
@else
    <a href="{{ $cUrl }}" 
       {!! $isExt ? 'target="_blank" rel="noopener"' : '' !!}
       class="bappeda-sub-item flex items-center gap-2 px-3.5 py-2 text-xs font-medium rounded-lg transition no-underline text-decoration-none truncate {{ $isChildActive ? 'is-active' : '' }}"
       style="color: {{ $isChildActive ? '#1A56DB' : '#334155' }} !important; background-color: {{ $isChildActive ? '#eff6ff' : 'transparent' }} !important;">
        <i class="fas fa-angle-right text-[8px] flex-shrink-0 transition-colors" style="color: {{ $isChildActive ? '#1A56DB' : '#cbd5e1' }} !important;"></i>
        <span class="truncate" style="color: inherit !important;">{{ $children->name }}</span>
    </a>
@endif
