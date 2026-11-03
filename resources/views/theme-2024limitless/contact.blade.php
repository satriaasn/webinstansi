@extends(getTheme('layouts.app'))
@section('title', 'Hubungi Kami')

@push('meta')
    @include('metadefault')
@endpush

@section('content')

<!-- Header Breadcrumb Banner (Tailwind CSS) -->
<div class="bg-gradient-to-r from-[#0B2545] to-blue-900 text-white py-10 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-blue-200 mb-3">
            <a href="{{ url('') }}" class="hover:text-white transition flex items-center gap-1"><i class="fas fa-home"></i> Beranda</a>
            <i class="fas fa-chevron-right text-[9px] text-blue-300"></i>
            <span class="text-white font-semibold">Hubungi Kami</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
            Kontak & Layanan Informasi
        </h1>
        <p class="text-xs sm:text-sm text-blue-100 mt-2 max-w-2xl">
            Sampaikan aspirasi, pertanyaan, konsultasi perencanaan, atau pengaduan Anda langsung kepada Bappeda Provinsi Lampung.
        </p>
    </div>
</div>

<!-- Main Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Form & Info (8 cols) -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Contact Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-location-dot text-base"></i>
                    </div>
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Kantor</div>
                        <p class="text-xs text-slate-700 font-medium leading-relaxed">
                            {{ getSetting('address') ?: 'Jl. Robert Wolter Monginsidi No. 223, Bandar Lampung' }}
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-phone text-base"></i>
                    </div>
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Telepon & Fax</div>
                        <p class="text-xs text-slate-700 font-medium leading-relaxed">
                            {{ getSetting('telephone') ?: '(0721) 481144' }}
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-envelope text-base"></i>
                    </div>
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Email Resmi</div>
                        <a href="mailto:{{ getSetting('email') }}" class="text-xs text-blue-700 font-medium hover:underline break-all">
                            {{ getSetting('email') ?: 'bappeda@lampungprov.go.id' }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
                <div class="mb-6 border-b border-slate-100 pb-4">
                    <h2 class="text-lg font-bold text-slate-800">Kirim Pesan / Pengaduan</h2>
                    <p class="text-xs text-slate-500 mt-1">Silakan lengkapi formulir di bawah ini dengan informasi yang valid.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-xs text-red-700">
                        <div class="font-bold flex items-center gap-1.5 mb-1 text-red-800">
                            <i class="fas fa-circle-exclamation"></i> Terjadi kesalahan pengisian:
                        </div>
                        <ul class="list-disc list-inside space-y-0.5 ml-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('flash_message'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-center gap-2">
                        <i class="fas fa-circle-check text-emerald-600 text-base"></i>
                        <span>{{ session('flash_message') }}</span>
                    </div>
                @endif

                <form action="{{ url('/contact/submit') }}" method="POST" class="space-y-4">
                    {{ csrf_field() }}

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5" for="name">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition placeholder-slate-400"
                                   placeholder="Masukkan nama Anda">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5" for="email">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition placeholder-slate-400"
                                   placeholder="nama@email.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5" for="subject">Subjek / Judul Pesan <span class="text-red-500">*</span></label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition placeholder-slate-400"
                               placeholder="Topik pengaduan, saran, atau permohonan informasi">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5" for="message">Isi Pesan / Pertanyaan <span class="text-red-500">*</span></label>
                        <textarea id="message" name="message" rows="5" required
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition placeholder-slate-400"
                                  placeholder="Tuliskan pesan Anda secara rinci...">{{ old('message') }}</textarea>
                    </div>

                    <!-- Captcha & Submit -->
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-100">
                        <div class="flex items-center gap-2.5 w-full sm:w-auto">
                            <div class="captcha flex items-center bg-slate-100 rounded-xl p-1 border border-slate-200">
                                <span class="px-2">{!! captcha_img() !!}</span>
                                <button type="button" id="reload" title="Refresh Captcha"
                                        class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-blue-700 hover:border-blue-300 transition flex items-center justify-center text-xs shadow-sm">
                                    <i class="fas fa-rotate"></i>
                                </button>
                            </div>
                            <input id="captcha" type="text" name="captcha" required
                                   class="w-32 px-3 py-2 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition placeholder-slate-400"
                                   placeholder="Kode Captcha">
                        </div>

                        <button type="submit"
                                class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-sm hover:shadow">
                            <span>Kirim Pesan</span>
                            <i class="fas fa-paper-plane text-[10px]"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Map Google Embed if available or placeholder -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <i class="fas fa-map-location-dot text-blue-700"></i> Peta Lokasi Kantor Bappeda
                </h3>
                <div class="w-full h-72 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                    <iframe 
                        src="https://maps.google.com/maps?q=-5.433890,105.257770&hl=id&z=16&output=embed" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

        </div>

        <!-- Sidebar (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            @include(getTheme('partials.sidebar'))
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('#reload').click(function () {
            $.ajax({
                type: 'GET',
                url: '{{ url("reload-captcha") }}',
                success: function (data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    });
</script>
@endpush