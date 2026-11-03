<!-- Modern Panoramic Footer Bappeda Provinsi Lampung (Matching Mockup) -->
<footer class="relative text-white font-sans overflow-hidden bg-[#002B5C]"
        style="background: #002B5C url('{{ asset('assets/images/footer_skyline_lampung.png') }}') no-repeat bottom center; background-size: cover;">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-7 pb-24 md:pb-28 lg:pb-32">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 lg:gap-2">
            
            <!-- 1. Brand Logo & Title -->
            <div class="flex items-center gap-3 flex-shrink-0">
                <img src="{{ berkas(getSetting('logo')) ?: asset('assets/images/logo_lampung.png') }}" 
                     alt="{{ getSetting('web_name') ?: 'Bappeda Provinsi Lampung' }}" 
                     onerror="this.onerror=null;this.src='{{ asset('assets/images/logo_lampung.png') }}'"
                     class="h-10 sm:h-11 w-auto object-contain drop-shadow">
                <div class="leading-tight">
                    <div class="text-white font-black text-sm tracking-wider uppercase">BAPPEDA</div>
                    <div class="text-white/95 font-extrabold text-[10px] tracking-wider uppercase">PROVINSI LAMPUNG</div>
                </div>
            </div>

            <!-- Divider 1 -->
            <div class="hidden xl:block h-9 w-[1px] bg-white/20 flex-shrink-0"></div>

            <!-- 2. Address -->
            <div class="flex items-start gap-2.5 flex-shrink-0">
                <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0 text-white mt-0.5">
                    <i class="fas fa-location-dot text-xs"></i>
                </div>
                <div class="text-white text-xs leading-snug">
                    <div class="font-medium">Jl. Basuki Rahmat No. 86</div>
                    <div class="text-white/80">Bandar Lampung, 35214</div>
                </div>
            </div>

            <!-- Divider 2 -->
            <div class="hidden xl:block h-9 w-[1px] bg-white/20 flex-shrink-0"></div>

            <!-- 3. Contact (Phone & Email) -->
            <div class="flex flex-col gap-1 text-white text-xs flex-shrink-0">
                <div class="flex items-center gap-2">
                    <i class="fas fa-phone-alt text-white text-xs w-4 text-center"></i>
                    <span>{{ getSetting('telephone') ?: '(0721) 470411' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-envelope text-white text-xs w-4 text-center"></i>
                    <a href="mailto:{{ getSetting('email') ?: 'bappeda@lampungprov.go.id' }}" class="text-white hover:underline transition">
                        {{ getSetting('email') ?: 'bappeda@lampungprov.go.id' }}
                    </a>
                </div>
            </div>

            <!-- Divider 3 -->
            <div class="hidden xl:block h-9 w-[1px] bg-white/20 flex-shrink-0"></div>

            <!-- 4. Ikuti Kami (Social Media) -->
            <div class="flex flex-col gap-1.5 flex-shrink-0">
                <div class="text-[11px] font-bold text-white tracking-wide">Ikuti Kami</div>
                <div class="flex items-center gap-2 text-white">
                    <a href="{{ getSetting('youtube') ?: 'https://youtube.com' }}" target="_blank" rel="noopener" class="w-6 h-6 rounded bg-white/10 hover:bg-white/25 flex items-center justify-center transition text-white" title="YouTube">
                        <i class="fab fa-youtube text-[11px]"></i>
                    </a>
                    <a href="{{ getSetting('instagram') ?: 'https://instagram.com' }}" target="_blank" rel="noopener" class="w-6 h-6 rounded bg-white/10 hover:bg-white/25 flex items-center justify-center transition text-white" title="Instagram">
                        <i class="fab fa-instagram text-[11px]"></i>
                    </a>
                    <a href="{{ getSetting('facebook') ?: 'https://facebook.com' }}" target="_blank" rel="noopener" class="w-6 h-6 rounded bg-white/10 hover:bg-white/25 flex items-center justify-center transition text-white" title="Facebook">
                        <i class="fab fa-facebook-f text-[11px]"></i>
                    </a>
                    <a href="{{ getSetting('twitter') ?: 'https://twitter.com' }}" target="_blank" rel="noopener" class="w-6 h-6 rounded bg-white/10 hover:bg-white/25 flex items-center justify-center transition text-white" title="X (Twitter)">
                        <i class="fab fa-x-twitter text-[11px]"></i>
                    </a>
                    <a href="https://t.me" target="_blank" rel="noopener" class="w-6 h-6 rounded bg-white/10 hover:bg-white/25 flex items-center justify-center transition text-white" title="Telegram">
                        <i class="fab fa-telegram-plane text-[11px]"></i>
                    </a>
                </div>
            </div>

            <!-- Divider 4 -->
            <div class="hidden xl:block h-9 w-[1px] bg-white/20 flex-shrink-0"></div>

            <!-- 5. Legal Links & Copyright -->
            <div class="flex flex-col gap-1 text-left lg:text-right text-xs flex-shrink-0">
                <div class="flex items-center lg:justify-end gap-2 text-[11px] text-white/90">
                    <a href="{{ url('pages/kebijakan-privasi') }}" class="hover:text-white hover:underline transition">Kebijakan Privasi</a>
                    <span class="text-white/40">|</span>
                    <a href="{{ url('pages/disclaimer') }}" class="hover:text-white hover:underline transition">Disclaimer</a>
                    <span class="text-white/40">|</span>
                    <a href="{{ url('pages/sitemap') }}" class="hover:text-white hover:underline transition">Sitemap</a>
                </div>
                <div class="text-[10px] text-white/70">
                    &copy; {{ date('Y') }} Bappeda Provinsi Lampung. All Rights Reserved.
                </div>
            </div>

        </div>
    </div>
</footer>
