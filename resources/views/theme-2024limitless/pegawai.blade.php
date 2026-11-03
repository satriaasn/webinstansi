@extends(getTheme('layouts.app'))
@section('title', 'Profil Pegawai Bappeda')

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
            <span class="text-white font-semibold">Profil Pegawai</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
            Profil Pegawai & Sumber Daya Manusia
        </h1>
        <p class="text-xs sm:text-sm text-blue-100 mt-2 max-w-2xl">
            Aparatur Sipil Negara dan staf profesional Badan Perencanaan Pembangunan Daerah Provinsi Lampung.
        </p>
    </div>
</div>

<!-- Main Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    
    @if(count($pegawais) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($pegawais as $pegawai)
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <!-- Header with Photo and Name -->
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 flex-shrink-0">
                                @if(!empty($pegawai->picture))
                                    <img src="{{ berkas($pegawai->picture) ?: url('berkas/' . $pegawai->picture) }}" 
                                         alt="{{ $pegawai->nama_pegawai }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-blue-50 text-blue-600 text-xl font-bold">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                @if(!empty($pegawai->klasifikasi_pegawai))
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-700 mb-1">
                                        {{ $pegawai->klasifikasi_pegawai }}
                                    </span>
                                @endif
                                <h3 class="text-sm font-bold text-slate-800 leading-snug">
                                    {{ $pegawai->nama_pegawai }}
                                </h3>
                                @if(!empty($pegawai->nip))
                                    <p class="text-[11px] text-slate-400 font-mono mt-0.5">
                                        NIP. {{ $pegawai->nip }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Position & Grade -->
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs mb-3 space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 text-[11px]">Jabatan:</span>
                                <span class="font-semibold text-slate-700 text-right">{{ $pegawai->jabatan ?: '-' }}</span>
                            </div>
                            @if(!empty($pegawai->golongan))
                                <div class="flex items-center justify-between border-t border-slate-200/60 pt-1">
                                    <span class="text-slate-400 text-[11px]">Golongan:</span>
                                    <span class="font-semibold text-slate-700">{{ $pegawai->golongan }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Description -->
                        @if(!empty($pegawai->deskripsi))
                            <div class="text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                                {!! $pegawai->deskripsi !!}
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                        <span>Bappeda Prov. Lampung</span>
                        <span class="inline-flex items-center gap-1 text-emerald-600 font-semibold">
                            <i class="fas fa-circle-check text-[10px]"></i> Aktif
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            {!! $pegawais->render() !!}
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center text-slate-400 text-sm">
            <i class="fas fa-users text-4xl mb-3 text-slate-300 block"></i>
            Data kepegawaian belum tersedia.
        </div>
    @endif

</div>

@endsection
