@php
    $mUrl = menuUrl($menu->url);
    $isExt = isExternalUrl($menu->url);
    $hasChildren = $menu->children && $menu->children->count() > 0;
    $isRightSide = in_array(strtolower($menu->name), ['dokumen', 'galeri', 'ppid', 'link', 'kontak']);

    // Check if this menu or any of its children matches current path
    $currentPath = trim(request()->path(), '/');
    $isActive = false;
    if ($menu->url && $menu->url !== '#' && $menu->url !== 'javascript:void(0)') {
        $cleanMenuUrl = trim(str_replace(url(''), '', $mUrl), '/');
        $isActive = ($currentPath === $cleanMenuUrl) || (strlen($cleanMenuUrl) > 2 && str_starts_with($currentPath, $cleanMenuUrl));
    }
    if (!$isActive && $hasChildren) {
        foreach ($menu->children as $ch) {
            $chClean = trim(str_replace(url(''), '', menuUrl($ch->url)), '/');
            if ($chClean && $chClean !== '#' && ($currentPath === $chClean || (strlen($chClean) > 2 && str_starts_with($currentPath, $chClean)))) {
                $isActive = true;
                break;
            }
            if ($ch->children && $ch->children->count() > 0) {
                foreach ($ch->children as $sub) {
                    $subClean = trim(str_replace(url(''), '', menuUrl($sub->url)), '/');
                    if ($subClean && $subClean !== '#' && ($currentPath === $subClean || (strlen($subClean) > 2 && str_starts_with($currentPath, $subClean)))) {
                        $isActive = true;
                        break 2;
                    }
                }
            }
        }
    }
@endphp

@if (strtolower($menu->name) == 'home' || strtolower($menu->name) == 'beranda' || $menu->url == '/' || $menu->url == 'home')
    {{-- Home is already rendered as the blue icon button in navbar --}}
@elseif ($hasChildren)
    <li class="relative group">
        <a href="{{ $mUrl }}" 
           {!! $isExt ? 'target="_blank" rel="noopener"' : '' !!}
           class="bappeda-nav-item flex items-center gap-1.5 px-3 py-2 text-xs font-bold rounded-lg transition tracking-normal no-underline text-decoration-none {{ $isActive ? 'is-active' : '' }}"
           style="color: {{ $isActive ? '#1A56DB' : '#1e293b' }} !important; background-color: {{ $isActive ? '#eff6ff' : 'transparent' }} !important;">
            <span class="bappeda-nav-label" style="color: inherit !important;">{{ $menu->name }}</span>
            <i class="fas fa-chevron-down text-[8px] transition-transform duration-200 group-hover:rotate-180 flex-shrink-0 bappeda-nav-chevron" style="color: {{ $isActive ? '#1A56DB' : '#64748b' }} !important;"></i>
        </a>
        <div class="absolute {{ $isRightSide ? 'right-0' : 'left-0' }} top-full pt-1.5 hidden group-hover:block z-50">
            <div class="{{ $menu->children->count() > 10 ? 'w-[520px] grid grid-cols-2 gap-x-2 gap-y-0.5 p-2' : 'w-64 py-1.5 divide-y divide-slate-50' }} bg-white rounded-2xl shadow-2xl border border-slate-100 text-left bappeda-dropdown-menu" style="background-color: #ffffff !important;">
                @foreach ($menu->children as $children)
                    @include(getTheme('partials.menus_child'), ['children' => $children, 'isRightSide' => $isRightSide])
                @endforeach
            </div>
        </div>
    </li>
@else
    <li>
        <a href="{{ $mUrl }}" 
           {!! $isExt ? 'target="_blank" rel="noopener"' : '' !!}
           class="bappeda-nav-item block px-3 py-2 text-xs font-bold rounded-lg transition tracking-normal no-underline text-decoration-none {{ $isActive ? 'is-active' : '' }}"
           style="color: {{ $isActive ? '#1A56DB' : '#1e293b' }} !important; background-color: {{ $isActive ? '#eff6ff' : 'transparent' }} !important;">
            <span class="bappeda-nav-label" style="color: inherit !important;">{{ $menu->name }}</span>
        </a>
    </li>
@endif
