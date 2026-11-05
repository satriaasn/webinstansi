@extends('layouts.backend')
@section('title', 'Layanan PPID - Permohonan Informasi')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item">Layanan PPID</span>
            <span class="breadcrumb-item active">Permohonan Informasi</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-paper-outline"></i>
        <div>
            <h4>Permohonan Informasi Publik (PPID)</h4>
            <p class="mg-b-0">Kelola dan tanggapi seluruh permohonan informasi publik dari masyarakat secara terintegrasi.</p>
        </div>
    </div>

    <div class="br-pagebody">
        @if(Session::has('flash_message'))
            <div class="alert alert-success alert-bordered pd-y-15 mb-3" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-flex align-items-center">
                    <i class="fa fa-check-circle tx-24 mr-2"></i>
                    <span>{{ Session::get('flash_message') }}</span>
                </div>
            </div>
        @endif

        <!-- Modern Stat Counter Cards (High Contrast & Proportional) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 font-sans">
            <!-- Card 1: Total Masuk -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:border-blue-400 hover:shadow-md transition cursor-pointer filter-card group" data-status="">
                <div class="flex items-center justify-between">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#1A56DB] flex items-center justify-center text-lg group-hover:scale-110 transition shadow-xs">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-50 px-2.5 py-1 rounded-md border border-blue-200">
                        Semua
                    </span>
                </div>
                <div class="mt-3">
                    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Masuk</div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">{{ $counts['total'] }}</div>
                </div>
                <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                    <span>Semua permohonan</span>
                    <i class="fas fa-arrow-right text-[10px] text-slate-300 group-hover:text-blue-600 group-hover:translate-x-0.5 transition"></i>
                </div>
            </div>

            <!-- Card 2: Menunggu Verifikasi -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:border-amber-400 hover:shadow-md transition cursor-pointer filter-card group" data-status="pending">
                <div class="flex items-center justify-between">
                    <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg group-hover:scale-110 transition shadow-xs">
                        <i class="fas fa-clock"></i>
                    </div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200">
                        Pending
                    </span>
                </div>
                <div class="mt-3">
                    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Menunggu Verifikasi</div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-800 mt-1 flex items-center gap-2">
                        <span>{{ $counts['pending'] }}</span>
                        @if($counts['pending'] > 0)
                            <span class="text-[10px] font-bold text-rose-600 bg-rose-50 border border-rose-200 px-2 py-0.5 rounded-full animate-pulse">Perlu Respon</span>
                        @endif
                    </div>
                </div>
                <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                    <span>Belum diproses</span>
                    <i class="fas fa-arrow-right text-[10px] text-slate-300 group-hover:text-amber-600 group-hover:translate-x-0.5 transition"></i>
                </div>
            </div>

            <!-- Card 3: Sedang Diproses -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:border-sky-400 hover:shadow-md transition cursor-pointer filter-card group" data-status="diproses">
                <div class="flex items-center justify-between">
                    <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg group-hover:scale-110 transition shadow-xs">
                        <i class="fas fa-gears"></i>
                    </div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-sky-700 bg-sky-50 px-2.5 py-1 rounded-md border border-sky-200">
                        Proses
                    </span>
                </div>
                <div class="mt-3">
                    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Sedang Diproses</div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">{{ $counts['diproses'] }}</div>
                </div>
                <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                    <span>Dalam tindak lanjut</span>
                    <i class="fas fa-arrow-right text-[10px] text-slate-300 group-hover:text-sky-600 group-hover:translate-x-0.5 transition"></i>
                </div>
            </div>

            <!-- Card 4: Diterima / Selesai -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:border-emerald-400 hover:shadow-md transition cursor-pointer filter-card group" data-status="selesai">
                <div class="flex items-center justify-between">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg group-hover:scale-110 transition shadow-xs">
                        <i class="fas fa-circle-check"></i>
                    </div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200">
                        Selesai
                    </span>
                </div>
                <div class="mt-3">
                    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Diterima / Selesai</div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">{{ $counts['selesai'] }}</div>
                </div>
                <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                    <span>Permohonan tuntas</span>
                    <i class="fas fa-arrow-right text-[10px] text-slate-300 group-hover:text-emerald-600 group-hover:translate-x-0.5 transition"></i>
                </div>
            </div>
        </div>

        <div class="br-section-wrapper font-sans">
            <!-- Filter Nav & Action Bar -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 mb-5 pb-4 border-b border-slate-100">
                <div class="flex flex-wrap items-center gap-1.5" role="group">
                    <button type="button" class="btn-filter active px-3.5 py-2 rounded-xl text-xs font-bold transition bg-[#1A56DB] text-white shadow-sm" data-status="">Semua ({{ $counts['total'] }})</button>
                    <button type="button" class="btn-filter px-3.5 py-2 rounded-xl text-xs font-bold transition bg-slate-100 text-slate-700 hover:bg-amber-50 hover:text-amber-700 border border-transparent hover:border-amber-200" data-status="pending">Menunggu ({{ $counts['pending'] }})</button>
                    <button type="button" class="btn-filter px-3.5 py-2 rounded-xl text-xs font-bold transition bg-slate-100 text-slate-700 hover:bg-sky-50 hover:text-sky-700 border border-transparent hover:border-sky-200" data-status="diproses">Diproses ({{ $counts['diproses'] }})</button>
                    <button type="button" class="btn-filter px-3.5 py-2 rounded-xl text-xs font-bold transition bg-slate-100 text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border border-transparent hover:border-emerald-200" data-status="selesai">Selesai ({{ $counts['selesai'] }})</button>
                    <button type="button" class="btn-filter px-3.5 py-2 rounded-xl text-xs font-bold transition bg-slate-100 text-slate-700 hover:bg-rose-50 hover:text-rose-700 border border-transparent hover:border-rose-200" data-status="ditolak">Ditolak ({{ $counts['ditolak'] }})</button>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ url('permohonan-informasi') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-[#1A56DB] border border-slate-200 text-xs font-bold transition text-decoration-none shadow-xs">
                        <i class="fas fa-arrow-up-right-from-square text-[10px]"></i> Buka Form Publik
                    </a>
                    <a href="{{ url('permohonan-informasi/tracking') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-[#1A56DB] border border-slate-200 text-xs font-bold transition text-decoration-none shadow-xs">
                        <i class="fas fa-magnifying-glass text-[10px]"></i> Cek Tracking
                    </a>
                </div>
            </div>

            {!! Form::open(['url' => 'dashboard/permohonan-informasi/deleteall', 'method' => 'post', 'id' => 'formDeleteAll']) !!}
            <div class="table-wrapper">
                <table class="table display responsive nowrap table-hover w-full" id="permohonan-table" style="width:100%;">
                    <thead>
                    <tr>
                        <th style="text-align:center;" width="15"></th>
                        <th class="all" width="140">No. Tiket</th>
                        <th>Pemohon</th>
                        <th>Informasi Dimohon</th>
                        <th class="all" width="110">Status</th>
                        <th width="80" style="text-align:center;">Email Notif</th>
                        <th width="100">Tanggal</th>
                        <th class="all" style="text-align:center;" width="110">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td style="text-align:center;">
                            <input type="checkbox" id="titleCheck" data-toggle="tooltip" title="Pilih Semua"/>
                        </td>
                        <td colspan="7">
                            <button class="btn btn-sm btn-danger inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold" type="button" onclick="confirmDeleteSelected()">
                                <i class="fas fa-trash-alt text-xs"></i> Hapus yang Dipilih
                            </button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            var currentStatus = '';

            var table = $('#permohonan-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: {
                    url: '{{ url("dashboard/permohonan-informasi/data") }}',
                    data: function (d) {
                        d.status = currentStatus;
                    }
                },
                order: [[6, 'desc']],
                columnDefs: [
                    { targets: 0, orderable: false, searchable: false, width: '20px' },
                    { targets: 1, className: 'all', responsivePriority: 1, width: '140px' },
                    { targets: 2, responsivePriority: 2, width: '200px' },
                    { targets: 3, responsivePriority: 3 },
                    { targets: 4, className: 'all', responsivePriority: 1, width: '120px' },
                    { targets: 5, responsivePriority: 2, width: '90px' },
                    { targets: 6, responsivePriority: 3, width: '110px' },
                    { targets: 7, className: 'all text-center', responsivePriority: 1, width: '110px' }
                ],
                columns: [
                    {data: 'check', name: 'check', orderable: false, searchable: false},
                    {data: 'nomor_tiket', name: 'nomor_tiket'},
                    {data: 'pemohon', name: 'nama_pemohon'},
                    {data: 'rincian_informasi', name: 'rincian_informasi'},
                    {data: 'status', name: 'status'},
                    {data: 'notif_email', name: 'notif_email', orderable: false, searchable: false, className: 'text-center'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'all text-center'},
                ],
                drawCallback: function () {
                    $("#titleCheck").prop('checked', false);
                    $("#titleCheck").click(function () {
                        var checked = $(this).is(':checked');
                        $('.deldata').prop('disabled', !checked);
                        $('input[id="titleCheckdel"]').prop('checked', checked);
                    });
                    $('input[id="titleCheckdel"]').click(function () {
                        $(this).next('.deldata').prop('disabled', !$(this).is(':checked'));
                    });
                }
            });

            // Filter status buttons
            $('.btn-filter, .filter-card').click(function () {
                var status = $(this).data('status');
                currentStatus = status;
                $('.btn-filter').removeClass('active bg-[#1A56DB] text-white shadow-sm').addClass('bg-slate-100 text-slate-700');
                $('.btn-filter[data-status="' + status + '"]').addClass('active bg-[#1A56DB] text-white shadow-sm').removeClass('bg-slate-100 text-slate-700');
                table.draw();
            });

            // Delete action handler
            $(document).on('click', '[data-delete]', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                if (confirm('Apakah Anda yakin ingin menghapus permohonan informasi ini?')) {
                    var form = $('<form action="' + url + '" method="POST">' +
                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                        '<input type="hidden" name="_method" value="DELETE">' +
                        '</form>');
                    $('body').append(form);
                    form.submit();
                }
            });
        });

        function confirmDeleteSelected() {
            var selected = $('input[id="titleCheckdel"]:checked').length;
            if (selected === 0) {
                alert('Silakan pilih setidaknya satu data untuk dihapus.');
                return;
            }
            if (confirm('Apakah Anda yakin ingin menghapus ' + selected + ' data permohonan terpilih?')) {
                $('#formDeleteAll').submit();
            }
        }
    </script>
@endpush

