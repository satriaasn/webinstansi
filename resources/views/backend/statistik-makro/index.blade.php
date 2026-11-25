@extends('layouts.backend')
@section('title', 'Statistik Indikator Makro')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Statistik Indikator Makro</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-pulse"></i>
        <div>
            <h4>Statistik Indikator Makro (Sync API)</h4>
            <p class="mg-b-0">Sinkronkan data indikator makro dari API Pusdatin &amp; centang data yang ingin ditampilkan di Beranda.</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">

            @if(session('flash_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle mr-1"></i> {{ session('flash_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-triangle mr-1"></i> {{ session('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Action Bar -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4" style="gap: 12px;">
                <div class="d-flex flex-wrap align-items-center" style="gap: 10px;">
                    <form action="{{ route('dashboard.statistik-makro.sync') }}" method="POST" class="d-inline" onsubmit="this.querySelector('button').disabled=true; this.querySelector('button').innerHTML='<i class=\'fa fa-spinner fa-spin\'></i> Menyinkronkan...';">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-refresh mr-1"></i> Sync Data API Sekarang
                        </button>
                    </form>
                    <span class="badge badge-info" style="font-size: 12px; padding: 6px 12px;">
                        Tampil di Beranda: <strong id="selected-counter">{{ $selectedCount }}</strong> dari {{ $items->count() }} indikator
                    </span>
                    @if($lastSynced)
                        <span class="text-muted" style="font-size: 12px;">
                            Terakhir sync: {{ \Carbon\Carbon::parse($lastSynced)->format('d M Y H:i') }}
                        </span>
                    @endif
                </div>

                <div style="min-width: 240px;">
                    <input type="text" id="makro-search" class="form-control form-control-sm" placeholder="Cari nama indikator / kategori...">
                </div>
            </div>

            <!-- Form Checklist Selection -->
            <form action="{{ route('dashboard.statistik-makro.save-selection') }}" method="POST">
                @csrf

                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div class="text-muted" style="font-size: 12px;">
                        <i class="fa fa-info-circle text-primary"></i> Centang indikator yang ingin ditampilkan di section <strong>Statistik Indikator Makro</strong> pada halaman depan, lalu klik <strong>Simpan Pilihan Tampilan</strong>.
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-save mr-1"></i> Simpan Pilihan Tampilan
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm" id="makro-table">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center" width="70">Tampil</th>
                                <th class="text-center" width="80">Urutan</th>
                                <th>Judul Indikator</th>
                                <th>Kategori</th>
                                <th class="text-right">Nilai Terbaru</th>
                                <th class="text-center">Perubahan</th>
                                <th class="text-center">Periode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr class="makro-row {{ $item->show_on_home ? 'table-primary' : '' }}">
                                    <td class="text-center align-middle">
                                        <input type="checkbox"
                                               name="selected_ids[]"
                                               value="{{ $item->id }}"
                                               class="makro-checkbox"
                                               style="width: 18px; height: 18px; cursor: pointer;"
                                               {{ $item->show_on_home ? 'checked' : '' }}>
                                    </td>
                                    <td class="text-center align-middle">
                                        <input type="number"
                                               name="urutan[{{ $item->id }}]"
                                               value="{{ $item->urutan }}"
                                               min="0"
                                               class="form-control form-control-sm text-center"
                                               style="width: 65px; margin: 0 auto;">
                                    </td>
                                    <td class="align-middle">
                                        <div class="font-weight-bold text-dark">{{ $item->judul }}</div>
                                        @if($item->sumber_data)
                                            <small class="text-muted">{{ $item->sumber_data }}</small>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-secondary">{{ $item->kategori_nama ?: '-' }}</span>
                                    </td>
                                    <td class="text-right align-middle font-weight-bold">
                                        {{ $item->nilai_formatted ?: $item->nilai_terbaru }}
                                        @if($item->satuan && !str_contains($item->nilai_formatted ?? '', '%'))
                                            <small class="text-muted font-weight-normal">{{ $item->satuan }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($item->delta_formatted)
                                            @php
                                                $isUp = $item->arah_perubahan === 'up';
                                                $isDown = $item->arah_perubahan === 'down';
                                                $isPositiveGood = ($item->jenis_indikator !== 'negatif');
                                                $isGood = ($isUp && $isPositiveGood) || ($isDown && !$isPositiveGood);
                                                $badgeCls = $item->arah_perubahan === 'flat' ? 'badge-secondary' : ($isGood ? 'badge-success' : 'badge-danger');
                                            @endphp
                                            <span class="badge {{ $badgeCls }}">
                                                {{ $item->delta_formatted }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $item->periode_terbaru ?: $item->periode }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        Belum ada data. Klik tombol <strong>Sync Data API Sekarang</strong> di atas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($items->count() > 0)
                    <div class="mt-3 text-right">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa fa-save mr-1"></i> Simpan Pilihan Tampilan
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            function updateCounter() {
                var count = $('.makro-checkbox:checked').length;
                $('#selected-counter').text(count);
            }

            $('.makro-checkbox').on('change', function () {
                $(this).closest('tr').toggleClass('table-primary', this.checked);
                updateCounter();
            });

            $('#makro-search').on('keyup', function () {
                var q = $(this).val().toLowerCase();
                $('#makro-table tbody .makro-row').each(function () {
                    var text = $(this).text().toLowerCase();
                    $(this).toggle(text.indexOf(q) !== -1);
                });
            });
        });
    </script>
@endpush
