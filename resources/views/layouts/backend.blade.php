<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ getSetting('web_description') }}">
    <meta name="author" content="{{ getSetting('web_owner') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - {{ getSetting('web_name') }}</title>

    <link rel="shortcut icon" href="{{ berkas(getSetting('favicon')) ?: asset('assets/images/logo_lampung.png') }}">

    <!-- Google Fonts & Font Awesome 6 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ callassetspath('backend/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">

    <!-- Vendor Stylesheets needed for Datatables & Form plugins -->
    <link href="{{ callassetspath('backend/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/datatables/jquery.dataTables.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/sweetalert/sweetalert2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ callassetspath('backend/lib/summernote/summernote-bs4.min.css') }}">
    <link href="{{ callassetspath('backend/lib/fancybox/jquery.fancybox.css') }}" rel="stylesheet">

    <!-- Tailwind CSS CDN with Custom Theme Palette -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            800: '#0B2545',
                            900: '#061D38',
                            950: '#031024',
                        },
                        bappeda: {
                            blue: '#1A56DB',
                            gold: '#F59E0B',
                            hover: '#1E40AF',
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* Modern Admin Clean Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Datatables Styling Overrides for Tailwind Aesthetic */
        .dataTables_wrapper { font-family: 'Poppins', sans-serif; font-size: 13px; color: #334155; }
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 12px;
            outline: none;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1A56DB !important;
            color: white !important;
            border: none;
            border-radius: 6px;
        }
        table.dataTable thead th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }
        table.dataTable tbody tr:hover {
            background-color: #f1f5f9;
        }

        /* Legacy compatibility helper classes */
        .br-section-wrapper {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }
        .br-pagetitle { display: none; }
        .br-pageheader { display: none; }
    </style>

    @stack('styles')

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body class="bg-[#F4F7FC] text-slate-800 font-sans antialiased flex h-screen overflow-hidden">

    <!-- ========================================================================
         1. SIDEBAR (Matching Mockup)
         ======================================================================== -->
    <aside id="admin-sidebar" 
           class="w-64 bg-[#061D38] text-white flex flex-col flex-shrink-0 transition-all duration-300 z-50 fixed inset-y-0 left-0 lg:static lg:translate-x-0 -translate-x-full shadow-2xl lg:shadow-none"
           style="background-image: url('{{ asset('assets/images/footer_skyline_lampung.png') }}'); background-repeat: no-repeat; background-position: bottom left; background-size: 100% auto;">
        
        <!-- Dark gradient overlay over the background image -->
        <div class="absolute inset-0 bg-[#061D38]/90 pointer-events-none"></div>

        <!-- Sidebar Header (Brand Logo) -->
        <div class="relative z-10 h-20 flex items-center gap-3 px-5 border-b border-white/10 flex-shrink-0">
            <img src="{{ berkas(getSetting('logo')) ?: asset('assets/images/logo_lampung.png') }}" 
                 alt="Logo Bappeda" 
                 onerror="this.onerror=null;this.src='{{ asset('assets/images/logo_lampung.png') }}'"
                 class="h-10 w-auto object-contain drop-shadow">
            <div class="leading-tight">
                <div class="text-white font-black text-sm tracking-wider uppercase">BAPPEDA</div>
                <div class="text-blue-200/90 font-extrabold text-[10px] tracking-wider uppercase">PROVINSI LAMPUNG</div>
            </div>
            <!-- Mobile Close Button -->
            <button type="button" id="btn-sidebar-close" class="lg:hidden ml-auto text-white/70 hover:text-white p-1">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="relative z-10 flex-1 overflow-y-auto px-3.5 py-4 space-y-1.5 text-xs font-medium">
            
            <!-- 1. Dashboard -->
            @php $isDashActive = Request::is('dashboard') && !Request::is('dashboard/*'); @endphp
            <a href="{{ url('/dashboard') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ $isDashActive ? 'bg-[#1A56DB] text-white font-bold shadow-md shadow-blue-900/40' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <i class="fas fa-house-chimney text-sm w-4 text-center"></i>
                <span class="flex-1">Dashboard</span>
            </a>

            <!-- 2. Berita & Informasi -->
            @php $isPostActive = Request::is('dashboard/post*') || Request::is('dashboard/pages*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isPostActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-newspaper text-sm w-4 text-center"></i>
                        <span>Berita & Informasi</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isPostActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isPostActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/post/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/post/table') ? 'text-white font-bold bg-white/10' : '' }}">Semua Berita</a>
                    <a href="{{ url('/dashboard/post/create') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/post/create') ? 'text-white font-bold bg-white/10' : '' }}">Tambah Berita</a>
                    <a href="{{ url('/dashboard/post-category/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/post-category*') ? 'text-white font-bold bg-white/10' : '' }}">Kategori Berita</a>
                    <a href="{{ url('/dashboard/pages/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/pages*') ? 'text-white font-bold bg-white/10' : '' }}">Halaman Statis</a>
                </div>
            </div>

            <!-- 3. Agenda Kegiatan -->
            @php $isAgendaActive = Request::is('dashboard/agenda*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isAgendaActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-calendar-days text-sm w-4 text-center"></i>
                        <span>Agenda Kegiatan</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isAgendaActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isAgendaActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/agenda/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/agenda/table') ? 'text-white font-bold bg-white/10' : '' }}">Semua Agenda</a>
                    <a href="{{ url('/dashboard/agenda/create') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/agenda/create') ? 'text-white font-bold bg-white/10' : '' }}">Tambah Agenda</a>
                </div>
            </div>

            <!-- 4. Dokumen -->
            @php $isDocActive = Request::is('dashboard/download*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isDocActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-folder-open text-sm w-4 text-center"></i>
                        <span>Dokumen Publik</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isDocActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isDocActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/download/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/download/table') ? 'text-white font-bold bg-white/10' : '' }}">Semua Dokumen</a>
                    <a href="{{ url('/dashboard/download/create') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/download/create') ? 'text-white font-bold bg-white/10' : '' }}">Tambah Dokumen</a>
                    <a href="{{ url('/dashboard/download-category/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/download-category*') ? 'text-white font-bold bg-white/10' : '' }}">Kategori Dokumen</a>
                </div>
            </div>

            <!-- 5. Galeri -->
            @php $isGalleryActive = Request::is('dashboard/gallery*') || Request::is('dashboard/album*') || Request::is('dashboard/video*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isGalleryActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-images text-sm w-4 text-center"></i>
                        <span>Galeri & Media</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isGalleryActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isGalleryActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/gallery/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/gallery*') ? 'text-white font-bold bg-white/10' : '' }}">Foto Kegiatan</a>
                    <a href="{{ url('/dashboard/album/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/album*') ? 'text-white font-bold bg-white/10' : '' }}">Album Foto</a>
                    <a href="{{ url('/dashboard/video/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/video*') ? 'text-white font-bold bg-white/10' : '' }}">Video Bappeda</a>
                </div>
            </div>

            <!-- 6. PPID (Permohonan Informasi) -->
            @php 
                $isPpidActive = Request::is('dashboard/permohonan-informasi*');
                $pendingPpid = \App\Models\PermohonanInformasi::where('status', 'pending')->count();
            @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isPpidActive ? 'bg-[#1A56DB] text-white font-bold' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-shield-halved text-sm w-4 text-center"></i>
                        <span>Layanan PPID</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        @if($pendingPpid > 0)
                            <span class="px-1.5 py-0.5 rounded-full bg-amber-400 text-slate-950 font-bold text-[10px]">{{ $pendingPpid }}</span>
                        @endif
                        <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isPpidActive ? 'rotate-180' : '' }}"></i>
                    </div>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isPpidActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/permohonan-informasi/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/permohonan-informasi/table') ? 'text-white font-bold bg-white/10' : '' }}">
                        Permohonan Masuk
                        @if($pendingPpid > 0)
                            <span class="ml-1 text-amber-300">({{ $pendingPpid }})</span>
                        @endif
                    </a>
                    <a href="{{ url('/permohonan-informasi') }}" target="_blank" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5">Form Publik &rarr;</a>
                    <a href="{{ url('/permohonan-informasi/tracking') }}" target="_blank" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5">Lacak Status &rarr;</a>
                </div>
            </div>

            <!-- 7. Pengaturan Konten -->
            @php $isContentActive = Request::is('dashboard/slider*') || Request::is('dashboard/pegawai*') || Request::is('dashboard/contact*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isContentActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-sliders text-sm w-4 text-center"></i>
                        <span>Pengaturan Konten</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isContentActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isContentActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/slider/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/slider*') ? 'text-white font-bold bg-white/10' : '' }}">Slider Beranda</a>
                    <a href="{{ url('/dashboard/pegawai/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/pegawai*') ? 'text-white font-bold bg-white/10' : '' }}">Data Pegawai</a>
                    <a href="{{ url('/dashboard/contact/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/contact*') ? 'text-white font-bold bg-white/10' : '' }}">Kontak Masuk</a>
                </div>
            </div>

            <!-- 8. Laporan & Menu -->
            @php $isReportActive = Request::is('dashboard/menu*') || Request::is('dashboard/activitylogs*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isReportActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-chart-pie text-sm w-4 text-center"></i>
                        <span>Laporan & Menu</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isReportActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isReportActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/menu/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/menu*') ? 'text-white font-bold bg-white/10' : '' }}">Struktur Menu Website</a>
                    @if(Auth::check() && optional(Auth::user())->hasRole('superadmin'))
                        <a href="{{ url('/dashboard/activitylogs/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/activitylogs*') ? 'text-white font-bold bg-white/10' : '' }}">Log Aktivitas Pengguna</a>
                    @endif
                </div>
            </div>

            <!-- 9. Pengguna -->
            @php $isUserActive = Request::is('dashboard/users*') || Request::is('dashboard/roles*') || Request::is('dashboard/permissions*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isUserActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-users-gear text-sm w-4 text-center"></i>
                        <span>Pengguna</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isUserActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isUserActive ? '' : 'hidden' }}">
                    @if(Auth::check() && (optional(Auth::user())->hasRole('superadmin') || optional(Auth::user())->hasRole('admin')))
                        <a href="{{ url('/dashboard/users/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/users/table') ? 'text-white font-bold bg-white/10' : '' }}">Semua Pengguna</a>
                        <a href="{{ url('/dashboard/users/create') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/users/create') ? 'text-white font-bold bg-white/10' : '' }}">Tambah Pengguna</a>
                        @if(optional(Auth::user())->hasRole('superadmin'))
                            <a href="{{ url('/dashboard/roles/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/roles*') ? 'text-white font-bold bg-white/10' : '' }}">Role & Hak Akses</a>
                            <a href="{{ url('/dashboard/permissions/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/permissions*') ? 'text-white font-bold bg-white/10' : '' }}">Izin (Permissions)</a>
                        @endif
                    @else
                        @if(Auth::check())
                            <a href="{{ url('/dashboard/users/'.Hashids::encode(Auth::user()->id).'/edit') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5">Edit Akun Saya</a>
                        @endif
                    @endif
                </div>
            </div>

            <!-- 10. Pengaturan Sistem -->
            @php $isSettingActive = Request::is('dashboard/settings*') || Request::is('dashboard/theme*'); @endphp
            <div class="menu-dropdown">
                <button type="button" class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 menu-toggle {{ $isSettingActive ? 'text-white font-bold bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-gear text-sm w-4 text-center"></i>
                        <span>Pengaturan Sistem</span>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 chevron-icon {{ $isSettingActive ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="submenu pl-8 pr-2 py-1 space-y-1 {{ $isSettingActive ? '' : 'hidden' }}">
                    <a href="{{ url('/dashboard/settings') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/settings*') ? 'text-white font-bold bg-white/10' : '' }}">Pengaturan Umum (Logo & Kontak)</a>
                    @if(Auth::check() && optional(Auth::user())->hasRole('superadmin'))
                        <a href="{{ url('/dashboard/theme/table') }}" class="block py-1.5 px-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/5 {{ Request::is('dashboard/theme*') ? 'text-white font-bold bg-white/10' : '' }}">Tema Tampilan</a>
                    @endif
                </div>
            </div>

        </nav>

        <!-- Sidebar Footer -->
        <div class="relative z-10 px-5 py-4 border-t border-white/10 text-[10px] text-slate-400">
            <div class="font-bold text-white/90">Bappeda Provinsi Lampung</div>
            <div>&copy; {{ date('Y') }}. All rights reserved.</div>
        </div>
    </aside>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-950/50 z-40 lg:hidden hidden transition-opacity"></div>

    <!-- ========================================================================
         2. MAIN CONTENT AREA (Topbar + Page View)
         ======================================================================== -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- TOP NAVIGATION BAR (Matching Mockup) -->
        <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30 flex-shrink-0 shadow-sm">
            
            <!-- Left: Toggle & Global Search Bar -->
            <div class="flex items-center gap-3 sm:gap-4 flex-1 max-w-xl">
                <!-- Hamburger Button -->
                <button type="button" id="btn-sidebar-toggle" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
                    <i class="fas fa-bars text-base"></i>
                </button>

                <!-- Search Input Bar with Ctrl+K badge -->
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" id="admin-search-input" 
                           placeholder="Cari berita, agenda, atau dokumen..." 
                           class="w-full pl-9 pr-14 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-xs text-slate-800 placeholder-slate-400 transition">
                    <span class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none">
                        <kbd class="px-1.5 py-0.5 text-[10px] font-semibold text-slate-400 bg-white border border-slate-200 rounded shadow-xs">Ctrl + K</kbd>
                    </span>
                </div>
            </div>

            <!-- Right: Notifications & User Profile -->
            <div class="flex items-center gap-3 sm:gap-4">
                
                <!-- Notification Bell -->
                <a href="{{ url('dashboard/permohonan-informasi/table') }}" class="relative p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition" title="Notifikasi Permohonan">
                    <i class="fas fa-bell text-base"></i>
                    @if($pendingPpid > 0)
                        <span class="absolute top-1 right-1 w-4 h-4 rounded-full bg-rose-500 text-white font-bold text-[9px] flex items-center justify-center">
                            {{ $pendingPpid }}
                        </span>
                    @endif
                </a>

                <!-- User Profile Capsule with Dropdown -->
                <div class="relative">
                    <button type="button" id="btn-user-dropdown" class="flex items-center gap-2.5 p-1.5 rounded-full sm:rounded-xl hover:bg-slate-100 transition">
                        @if(Auth::check() && Auth::user()->picture)
                            <img src="{{ berkas(Auth::user()->picture) }}" alt="{{ optional(Auth::user())->name }}" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                        @else
                            <img src="{{ callassetspath('backend/images/avatar.jpg') }}" alt="User" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                        @endif
                        <div class="hidden sm:block text-left leading-tight pr-1">
                            <div class="text-xs font-bold text-slate-800">{{ Auth::check() ? Auth::user()->name : 'Administrator' }}</div>
                            <div class="text-[10px] text-slate-500">
                                {{ Auth::check() ? (optional(Auth::user())->hasRole('superadmin') ? 'Super Administrator' : (optional(Auth::user())->hasRole('admin') ? 'Administrator' : 'Editor')) : 'Administrator' }}
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-[10px] text-slate-400 hidden sm:block"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 text-xs">
                        <div class="px-4 py-2 border-b border-slate-100">
                            <div class="font-bold text-slate-900">{{ Auth::check() ? Auth::user()->name : 'Administrator' }}</div>
                            <div class="text-[11px] text-slate-500 truncate">{{ Auth::check() ? Auth::user()->email : 'admin@lampungprov.go.id' }}</div>
                        </div>
                        <div class="py-1">
                            <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2 text-slate-700 hover:bg-slate-50 transition">
                                <i class="fas fa-globe text-blue-600 w-4"></i>
                                <span>Kunjungi Website</span>
                            </a>
                            <a href="{{ Auth::check() ? url('/dashboard/users/'.Hashids::encode(Auth::user()->id).'/edit') : '#' }}" class="flex items-center gap-2.5 px-4 py-2 text-slate-700 hover:bg-slate-50 transition">
                                <i class="fas fa-user-pen text-indigo-600 w-4"></i>
                                <span>Edit Profil Saya</span>
                            </a>
                            <a href="{{ url('/dashboard/settings') }}" class="flex items-center gap-2.5 px-4 py-2 text-slate-700 hover:bg-slate-50 transition">
                                <i class="fas fa-sliders text-amber-600 w-4"></i>
                                <span>Pengaturan Website</span>
                            </a>
                        </div>
                        <div class="border-t border-slate-100 pt-1">
                            <a href="{{ url('/logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="flex items-center gap-2.5 px-4 py-2 text-rose-600 hover:bg-rose-50 transition font-semibold">
                                <i class="fas fa-arrow-right-from-bracket w-4"></i>
                                <span>Keluar (Logout)</span>
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </header>

        <!-- FLASH NOTIFICATION ALERT -->
        @if (Session::has('flash_message'))
            <div class="px-6 pt-5">
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2 font-medium">
                        <i class="fas fa-check-circle text-emerald-600 text-sm"></i>
                        <span>{{ Session::get('flash_message') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 p-1">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- PAGE CONTENT -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>

    </div>

    <!-- Delete Confirmation Modal (Standard Modal) -->
    <div id="alertalldel" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered bd-0" role="document">
            <div class="modal-content" style="width:36em; border-radius: 16px; overflow:hidden;">
                <div class="modal-body pd-25 text-center p-6">
                    <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-2xl mx-auto mb-3">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800 mb-1">Konfirmasi Hapus Data</h2>
                    <p class="text-xs text-slate-500 mb-6">Apakah Anda yakin ingin menghapus data yang dipilih? Data yang telah dihapus tidak dapat dipulihkan kembali.</p>
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="button" class="px-5 py-2.5 rounded-xl bg-rose-600 text-white font-bold text-xs hover:bg-rose-700 shadow transition" id="confirmdel">
                            Ya, Hapus Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ callassetspath('backend/lib/jquery/jquery.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/popper.js/popper.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/sweetalert/sweetalert2.min.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/fancybox/jquery.fancybox.js') }}"></script>
    <script src="{{ callassetspath('backend/js/deleter.js') }}"></script>

    <!-- Custom Interactive UI Logic -->
    <script>
        $(function () {
            // Sidebar Dropdown Toggle
            $('.menu-toggle').click(function () {
                var submenu = $(this).next('.submenu');
                var chevron = $(this).find('.chevron-icon');
                submenu.toggleClass('hidden');
                chevron.toggleClass('rotate-180');
            });

            // Mobile Sidebar Toggle
            $('#btn-sidebar-toggle').click(function () {
                $('#admin-sidebar').toggleClass('-translate-x-full');
                $('#sidebar-overlay').toggleClass('hidden');
            });

            $('#btn-sidebar-close, #sidebar-overlay').click(function () {
                $('#admin-sidebar').addClass('-translate-x-full');
                $('#sidebar-overlay').addClass('hidden');
            });

            // User Profile Dropdown Toggle
            $('#btn-user-dropdown').click(function (e) {
                e.stopPropagation();
                $('#user-dropdown-menu').toggleClass('hidden');
            });

            $(document).click(function () {
                $('#user-dropdown-menu').addClass('hidden');
            });

            // Keyboard shortcut Ctrl + K focus to search bar
            $(document).keydown(function (e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    $('#admin-search-input').focus();
                }
            });
        });
    </script>

    @stack('scripts')
    @yield('scripts')
</body>
</html>
