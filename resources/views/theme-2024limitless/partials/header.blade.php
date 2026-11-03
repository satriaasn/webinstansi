<!-- Top Bar Pemerintah Provinsi Lampung (Matching Mockup) -->
<div class="bg-[#092347] text-white text-xs py-2 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap justify-between items-center gap-3">
        <!-- Left: BerAKHLAK & Bangga Melayani Bangsa -->
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-1.5 font-bold tracking-wider text-xs">
                <span class="text-red-500 font-black">Ber</span><span class="text-white font-black tracking-normal">AKHLAK</span>
            </div>
            <div class="h-3 w-px bg-white/20 hidden sm:block"></div>
            <div class="text-[11px] text-blue-200 hidden sm:flex items-center gap-1 font-medium italic">
                <i class="fas fa-heart text-red-400 text-[10px]"></i> Bangga Melayani Bangsa
            </div>
        </div>

        <!-- Right: Links & Social Icons -->
        <div class="flex items-center gap-4 text-xs">
            <div class="flex items-center gap-3 text-[11px] text-blue-100 font-medium">
                <a href="{{ url('pages/informasi-pelayanan-publik') }}" class="hover:text-white transition">Layanan Publik</a>
                <span class="text-white/30">|</span>
                <a href="{{ url('pages/faq') }}" class="hover:text-white transition">FAQ</a>
                <span class="text-white/30">|</span>
                <a href="{{ url('contact') }}" class="hover:text-white transition">Kontak</a>
            </div>

            <!-- Social Media Icons -->
            <div class="flex items-center gap-2.5 border-l border-white/20 pl-4 text-blue-100">
                <a href="{{ getSetting('youtube') ?: 'https://youtube.com' }}" target="_blank" rel="noopener" class="hover:text-red-400 transition" title="YouTube"><i class="fab fa-youtube text-xs"></i></a>
                <a href="{{ getSetting('instagram') ?: 'https://instagram.com' }}" target="_blank" rel="noopener" class="hover:text-pink-400 transition" title="Instagram"><i class="fab fa-instagram text-xs"></i></a>
                <a href="{{ getSetting('facebook') ?: 'https://facebook.com' }}" target="_blank" rel="noopener" class="hover:text-blue-400 transition" title="Facebook"><i class="fab fa-facebook-f text-xs"></i></a>
                <a href="{{ getSetting('twitter') ?: 'https://twitter.com' }}" target="_blank" rel="noopener" class="hover:text-sky-300 transition" title="X (Twitter)"><i class="fab fa-x-twitter text-xs"></i></a>
            </div>
        </div>
    </div>
</div>

<style>
/* ==========================================================================
   BAPPEDA MODERN NAVBAR - BULLETPROOF HIGH CONTRAST COLORING RULES
   Guarantees dark slate text on white navbar regardless of CSS override
   ========================================================================== */
nav.bappeda-navbar-root {
    background-color: #ffffff !important;
}

/* Brand styling */
.bappeda-brand-name {
    color: #0B2545 !important;
    font-weight: 900 !important;
}
.bappeda-brand-region {
    color: #0B2545 !important;
    font-weight: 800 !important;
}
.bappeda-tagline-text {
    color: #1A56DB !important;
    font-weight: 600 !important;
}

/* Top-level menu link */
.bappeda-nav-list .bappeda-nav-item,
nav.bappeda-navbar-root .bappeda-nav-item,
nav.bappeda-navbar-root ul li a.bappeda-nav-item {
    color: #1e293b !important; /* Slate 800 */
    background-color: transparent !important;
    text-decoration: none !important;
    font-weight: 700 !important;
    transition: all 0.15s ease-in-out !important;
}

.bappeda-nav-list .bappeda-nav-item .bappeda-nav-label,
nav.bappeda-navbar-root .bappeda-nav-item .bappeda-nav-label {
    color: #1e293b !important;
}

.bappeda-nav-list .bappeda-nav-item .bappeda-nav-chevron,
nav.bappeda-navbar-root .bappeda-nav-item .bappeda-nav-chevron {
    color: #64748b !important; /* Slate 500 */
}

/* Hover & Group-hover states on desktop navbar */
.bappeda-nav-list .bappeda-nav-item:hover,
.bappeda-nav-list .group:hover > .bappeda-nav-item,
nav.bappeda-navbar-root .bappeda-nav-item:hover,
nav.bappeda-navbar-root .group:hover > .bappeda-nav-item {
    color: #1A56DB !important; /* Royal Blue */
    background-color: #eff6ff !important; /* Blue 50 */
}

.bappeda-nav-list .bappeda-nav-item:hover .bappeda-nav-label,
.bappeda-nav-list .group:hover > .bappeda-nav-item .bappeda-nav-label,
nav.bappeda-navbar-root .bappeda-nav-item:hover .bappeda-nav-label,
nav.bappeda-navbar-root .group:hover > .bappeda-nav-item .bappeda-nav-label {
    color: #1A56DB !important;
}

.bappeda-nav-list .bappeda-nav-item:hover .bappeda-nav-chevron,
.bappeda-nav-list .group:hover > .bappeda-nav-item .bappeda-nav-chevron,
nav.bappeda-navbar-root .bappeda-nav-item:hover .bappeda-nav-chevron,
nav.bappeda-navbar-root .group:hover > .bappeda-nav-item .bappeda-nav-chevron {
    color: #1A56DB !important;
}

/* Active state on desktop navbar */
.bappeda-nav-list .bappeda-nav-item.is-active,
nav.bappeda-navbar-root .bappeda-nav-item.is-active {
    color: #1A56DB !important;
    background-color: #eff6ff !important;
    font-weight: 800 !important;
}

.bappeda-nav-list .bappeda-nav-item.is-active .bappeda-nav-label,
nav.bappeda-navbar-root .bappeda-nav-item.is-active .bappeda-nav-label,
.bappeda-nav-list .bappeda-nav-item.is-active .bappeda-nav-chevron,
nav.bappeda-navbar-root .bappeda-nav-item.is-active .bappeda-nav-chevron {
    color: #1A56DB !important;
}

/* Dropdown Flyout Panel */
.bappeda-dropdown-menu {
    background-color: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
}

/* Dropdown Parent Item */
.bappeda-sub-parent {
    color: #334155 !important; /* Slate 700 */
    background-color: transparent !important;
    text-decoration: none !important;
    transition: all 0.15s ease !important;
}
.bappeda-sub-parent span {
    color: #334155 !important;
}
.bappeda-sub-parent i {
    color: #94a3b8 !important; /* Slate 400 */
}
.bappeda-sub-parent:hover,
.group\/sub:hover > .bappeda-sub-parent {
    color: #1A56DB !important;
    background-color: #eff6ff !important;
}
.bappeda-sub-parent:hover span,
.group\/sub:hover > .bappeda-sub-parent span,
.bappeda-sub-parent:hover i,
.group\/sub:hover > .bappeda-sub-parent i {
    color: #1A56DB !important;
}
.bappeda-sub-parent.is-active {
    color: #1A56DB !important;
    background-color: #eff6ff !important;
    font-weight: 700 !important;
}
.bappeda-sub-parent.is-active span,
.bappeda-sub-parent.is-active i {
    color: #1A56DB !important;
}

/* Dropdown Leaf Item */
.bappeda-sub-item {
    color: #334155 !important;
    background-color: transparent !important;
    text-decoration: none !important;
    transition: all 0.15s ease !important;
}
.bappeda-sub-item span {
    color: #334155 !important;
}
.bappeda-sub-item i {
    color: #cbd5e1 !important; /* Slate 300 */
}
.bappeda-sub-item:hover {
    color: #1A56DB !important;
    background-color: #eff6ff !important;
}
.bappeda-sub-item:hover span {
    color: #1A56DB !important;
}
.bappeda-sub-item:hover i {
    color: #1A56DB !important;
}
.bappeda-sub-item.is-active {
    color: #1A56DB !important;
    background-color: #eff6ff !important;
    font-weight: 700 !important;
}
.bappeda-sub-item.is-active span,
.bappeda-sub-item.is-active i {
    color: #1A56DB !important;
}

/* Home & Search Buttons */
.bappeda-nav-home-btn {
    background-color: #1A56DB !important;
    color: #ffffff !important;
}
.bappeda-nav-home-btn i {
    color: #ffffff !important;
}
.bappeda-nav-home-btn:hover {
    background-color: #1344B5 !important;
}

.bappeda-nav-search-btn {
    color: #334155 !important;
    background-color: transparent !important;
    border: none !important;
    cursor: pointer;
}
.bappeda-nav-search-btn:hover {
    color: #1A56DB !important;
    background-color: #eff6ff !important;
}
.bappeda-nav-search-btn i {
    color: inherit !important;
}

/* Universal safe guard against any Limitless [class*=bg-] rules */
nav.bappeda-navbar-root ul.bappeda-nav-list li a:not(.bappeda-nav-home-btn) {
    color: #1e293b !important;
}
nav.bappeda-navbar-root ul.bappeda-nav-list li a:not(.bappeda-nav-home-btn):hover {
    color: #1A56DB !important;
}

/* Mobile Menu Links */
#mobile-menu a {
    color: #334155 !important;
    text-decoration: none !important;
}
#mobile-menu a:hover {
    color: #1A56DB !important;
}
</style>

<!-- Main Navbar Bappeda (Matching Mockup) -->
<nav class="bappeda-navbar-root bg-white shadow-sm border-b border-slate-100 sticky top-0 z-50 font-sans transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 gap-4">
            <!-- Brand Logo & Title with Tagline -->
            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="{{ url('') }}" class="flex items-center gap-2.5 group text-decoration-none flex-shrink-0" style="text-decoration: none !important;">
                    <img src="{{ berkas(getSetting('logo')) ?: url('berkas/' . getSetting('logo')) }}" 
                         alt="Logo Bappeda Lampung" 
                         onerror="this.onerror=null;this.src='{{ asset('assets/images/logo_lampung.png') }}'"
                         class="h-11 w-auto drop-shadow-sm group-hover:scale-105 transition-transform duration-200">
                    <div class="flex flex-col flex-shrink-0">
                        <span class="bappeda-brand-name font-black text-base leading-tight tracking-wider">BAPPEDA</span>
                        <span class="bappeda-brand-region font-extrabold text-[10px] leading-tight tracking-wider uppercase">PROVINSI LAMPUNG</span>
                    </div>
                </a>

                <!-- Divider & Tagline -->
                <div class="hidden 2xl:flex items-center pl-3 border-l border-slate-300 flex-shrink-0">
                    <span class="bappeda-tagline-text text-xs font-semibold italic tracking-wide whitespace-nowrap">
                        Perencanaan Berkualitas untuk Lampung Maju
                    </span>
                </div>
            </div>

            <!-- Desktop Menu Items -->
            <div class="hidden lg:flex items-center gap-1 flex-shrink-0">
                <!-- Blue Home Icon Button -->
                <a href="{{ url('') }}" class="bappeda-nav-home-btn w-8 h-8 rounded-lg flex items-center justify-center shadow-sm transition mr-1 flex-shrink-0" title="Beranda">
                    <i class="fas fa-home text-xs"></i>
                </a>

                <!-- Menus Navigation -->
                <ul class="bappeda-nav-list flex items-center gap-0.5 mb-0 pl-0 list-none text-xs font-medium flex-shrink-0">
                    @each(getTheme('partials.menus'), App\Http\Controllers\HomeController::getMenus(), 'menu', getTheme('partials.menus'))
                </ul>

                <!-- Quick Search Nav Icon Button -->
                <button type="button" onclick="toggleNavSearch()" 
                   class="bappeda-nav-search-btn ml-1 w-8 h-8 rounded-lg flex items-center justify-center transition flex-shrink-0" 
                   title="Pencarian">
                    <i class="fas fa-magnifying-glass text-xs"></i>
                </button>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="lg:hidden flex items-center gap-2">
                <button type="button" onclick="toggleNavSearch()" 
                   class="w-9 h-9 rounded-lg bg-blue-50 text-[#1A56DB] flex items-center justify-center shadow-sm"
                   style="color: #1A56DB !important; background-color: #eff6ff !important;">
                    <i class="fas fa-search text-xs" style="color: #1A56DB !important;"></i>
                </button>
                <button type="button" 
                        onclick="document.getElementById('mobile-menu').classList.toggle('hidden');" 
                        class="p-2 rounded-lg text-slate-700 hover:bg-slate-100 transition focus:outline-none"
                        style="color: #334155 !important;">
                    <i class="fas fa-bars text-lg" style="color: #334155 !important;"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Universal Nav Search Bar Dropdown -->
    <div id="nav-search-bar" class="hidden border-t border-slate-100 bg-slate-50/95 backdrop-blur-md px-4 py-3 shadow-inner">
        <div class="max-w-3xl mx-auto">
            <form action="{{ url('home/search') }}" method="GET" class="relative flex items-center">
                <i class="fas fa-search absolute left-4 text-slate-400 text-sm"></i>
                <input type="text" name="query" id="nav-search-input" required
                       placeholder="Ketik kata kunci lalu tekan enter atau klik Cari..."
                       class="w-full pl-11 pr-24 py-2.5 rounded-full border border-slate-300 text-xs text-slate-800 bg-white focus:outline-none focus:ring-2 focus:ring-[#1A56DB] shadow-sm">
                <button type="submit" 
                        class="absolute right-1 px-4 py-1.5 rounded-full bg-[#1A56DB] hover:bg-[#1344B5] text-white font-bold text-xs shadow-sm transition"
                        style="background-color: #1A56DB !important; color: #ffffff !important;">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Menu Container -->
    <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-100 bg-white px-4 pt-3 pb-6 space-y-2 shadow-lg" style="background-color: #ffffff !important;">
        <ul class="space-y-1 list-none pl-0">
            @foreach(App\Http\Controllers\HomeController::getMenus() as $m)
                @if($m->children->count() > 0)
                    <li class="border-b border-slate-100 pb-2">
                        <div class="font-bold text-xs uppercase tracking-wider py-1 flex justify-between items-center" style="color: #0f172a !important;">
                            <span>{{ $m->name }}</span>
                        </div>
                        <ul class="pl-3 space-y-1 mt-1 list-none">
                            @foreach($m->children as $ch)
                                @php
                                    $chUrl = menuUrl($ch->url);
                                    $chExt = isExternalUrl($ch->url);
                                @endphp
                                <li>
                                    <a href="{{ $chUrl }}" {!! $chExt ? 'target="_blank" rel="noopener"' : '' !!} class="block py-1 text-xs no-underline text-decoration-none" style="color: #475569 !important;">
                                        {{ $ch->name }}
                                    </a>
                                    @if($ch->children && $ch->children->count() > 0)
                                        <ul class="pl-3 space-y-1 mt-0.5 list-none">
                                            @foreach($ch->children as $sub)
                                                <li>
                                                    <a href="{{ menuUrl($sub->url) }}" {!! isExternalUrl($sub->url) ? 'target="_blank" rel="noopener"' : '' !!} class="block py-0.5 text-[11px] no-underline text-decoration-none" style="color: #64748b !important;">
                                                        &bull; {{ $sub->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    @php
                        $mUrl = menuUrl($m->url);
                        $mExt = isExternalUrl($m->url);
                    @endphp
                    <li>
                        <a href="{{ $mUrl }}" {!! $mExt ? 'target="_blank" rel="noopener"' : '' !!} class="block py-2 text-xs font-bold uppercase tracking-wider border-b border-slate-100 no-underline text-decoration-none" style="color: #1e293b !important;">
                            {{ $m->name }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</nav>
