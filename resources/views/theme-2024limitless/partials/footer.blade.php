<!-- Modern Footer Bappeda Provinsi Lampung (Matching Mockup) -->
<footer class="bg-[#071D36] text-white text-xs font-sans relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Column 1: Brand Logo & Title (3 cols) -->
            <div class="lg:col-span-3">
                <div class="flex items-center gap-3">
                    <img src="{{ berkas(getSetting('logo')) ?: asset('assets/images/logo_lampung.png') }}" 
                         alt="{{ getSetting('web_name') }}" 
                         onerror="this.onerror=null;this.src='{{ asset('assets/images/logo_lampung.png') }}'"
                         class="h-12 w-auto drop-shadow">
                    <div>
                        <div class="text-white font-black text-sm tracking-wide">BAPPEDA</div>
                        <div class="text-white font-extrabold text-[11px] tracking-wider uppercase">PROVINSI LAMPUNG</div>
                    </div>
                </div>
            </div>

            <!-- Column 2: Alamat (3 cols) -->
            <div class="lg:col-span-3 space-y-2 text-slate-300 text-xs">
                <div class="flex items-start gap-2.5">
                    <i class="fas fa-location-dot text-blue-400 text-sm mt-0.5 flex-shrink-0"></i>
                    <span class="leading-relaxed">
                        {{ getSetting('address') ?: 'Jl. Basuki Rahmat No. 86 / Jl. Wolter Monginsidi No. 223, Bandar Lampung, 35214' }}
                    </span>
                </div>
            </div>

            <!-- Column 3: Kontak Telepon & Email (2 cols) -->
            <div class="lg:col-span-2 space-y-2 text-slate-300 text-xs">
                <div class="flex items-center gap-2">
                    <i class="fas fa-phone text-blue-400 text-xs flex-shrink-0"></i>
                    <span>{{ getSetting('telephone') ?: '(0721) 470411' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-envelope text-blue-400 text-xs flex-shrink-0"></i>
                    <a href="mailto:{{ getSetting('email') ?: 'bappeda@lampungprov.go.id' }}" class="text-slate-300 hover:text-white transition break-all">
                        {{ getSetting('email') ?: 'bappeda@lampungprov.go.id' }}
                    </a>
                </div>
            </div>

            <!-- Column 4: Ikuti Kami & Hak Cipta (4 cols) -->
            <div class="lg:col-span-4 flex flex-col justify-between space-y-4">
                <div>
                    <div class="text-[11px] font-bold text-white uppercase tracking-wider mb-2">Ikuti Kami</div>
                    <div class="flex items-center gap-3 text-slate-300">
                        <a href="{{ getSetting('youtube') ?: 'https://youtube.com' }}" target="_blank" rel="noopener" class="hover:text-red-400 text-sm transition" title="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="{{ getSetting('instagram') ?: 'https://instagram.com' }}" target="_blank" rel="noopener" class="hover:text-pink-400 text-sm transition" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="{{ getSetting('facebook') ?: 'https://facebook.com' }}" target="_blank" rel="noopener" class="hover:text-blue-400 text-sm transition" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ getSetting('twitter') ?: 'https://twitter.com' }}" target="_blank" rel="noopener" class="hover:text-sky-300 text-sm transition" title="X (Twitter)"><i class="fab fa-x-twitter"></i></a>
                        <a href="https://t.me" target="_blank" rel="noopener" class="hover:text-sky-400 text-sm transition" title="Telegram"><i class="fab fa-telegram"></i></a>
                    </div>
                </div>

                <div class="text-[11px] text-slate-400 space-y-1">
                    <div class="flex items-center gap-2">
                        <a href="{{ url('pages/kebijakan-privasi') }}" class="hover:text-slate-200 transition">Kebijakan Privasi</a>
                        <span>|</span>
                        <a href="{{ url('pages/disclaimer') }}" class="hover:text-slate-200 transition">Disclaimer</a>
                        <span>|</span>
                        <a href="{{ url('pages/sitemap') }}" class="hover:text-slate-200 transition">Sitemap</a>
                    </div>
                    <div>
                        © {{ date('Y') }} Bappeda Provinsi Lampung. All Rights Reserved.
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Lampung City Silhouette / Tapis Pattern Accent Banner at very bottom -->
    <div class="h-6 w-full bg-gradient-to-r from-amber-500 via-yellow-400 to-amber-500 flex items-center justify-center overflow-hidden opacity-90">
        <div class="w-full h-full opacity-30" style="background: repeating-linear-gradient(45deg, #000 0, #000 8px, transparent 8px, transparent 16px);"></div>
    </div>
</footer>
