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

        <!-- Stat Counter Cards -->
        <div class="row row-sm mg-b-20">
            <div class="col-sm-6 col-lg-3 mg-b-10">
                <div class="bg-primary rounded p-3 text-white d-flex align-items-center justify-content-between shadow-sm cursor-pointer filter-card" data-status="">
                    <div>
                        <div class="tx-11 tx-uppercase tx-spacing-1 font-weight-bold op-8">Total Masuk</div>
                        <div class="tx-24 tx-bold mg-t-5">{{ $counts['total'] }}</div>
                    </div>
                    <i class="fa fa-folder-open-o tx-40 op-4"></i>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mg-b-10">
                <div class="bg-warning rounded p-3 text-dark d-flex align-items-center justify-content-between shadow-sm cursor-pointer filter-card" data-status="pending">
                    <div>
                        <div class="tx-11 tx-uppercase tx-spacing-1 font-weight-bold op-8">Menunggu</div>
                        <div class="tx-24 tx-bold mg-t-5">{{ $counts['pending'] }}</div>
                    </div>
                    <i class="fa fa-clock-o tx-40 op-4"></i>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mg-b-10">
                <div class="bg-info rounded p-3 text-white d-flex align-items-center justify-content-between shadow-sm cursor-pointer filter-card" data-status="diproses">
                    <div>
                        <div class="tx-11 tx-uppercase tx-spacing-1 font-weight-bold op-8">Diproses</div>
                        <div class="tx-24 tx-bold mg-t-5">{{ $counts['diproses'] }}</div>
                    </div>
                    <i class="fa fa-cogs tx-40 op-4"></i>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mg-b-10">
                <div class="bg-success rounded p-3 text-white d-flex align-items-center justify-content-between shadow-sm cursor-pointer filter-card" data-status="selesai">
                    <div>
                        <div class="tx-11 tx-uppercase tx-spacing-1 font-weight-bold op-8">Diterima / Selesai</div>
                        <div class="tx-24 tx-bold mg-t-5">{{ $counts['selesai'] }}</div>
                    </div>
                    <i class="fa fa-check-circle-o tx-40 op-4"></i>
                </div>
            </div>
        </div>

        <div class="br-section-wrapper">
            <!-- Filter Nav -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mg-b-20 pb-3 border-bottom">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-primary active btn-filter" data-status="">Semua ({{ $counts['total'] }})</button>
                    <button type="button" class="btn btn-outline-warning btn-filter" data-status="pending">Menunggu ({{ $counts['pending'] }})</button>
                    <button type="button" class="btn btn-outline-info btn-filter" data-status="diproses">Diproses ({{ $counts['diproses'] }})</button>
                    <button type="button" class="btn btn-outline-success btn-filter" data-status="selesai">Selesai ({{ $counts['selesai'] }})</button>
                    <button type="button" class="btn btn-outline-danger btn-filter" data-status="ditolak">Ditolak ({{ $counts['ditolak'] }})</button>
                </div>
                <div>
                    <a href="{{ url('permohonan-informasi') }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                        <i class="fa fa-external-link"></i> Buka Form Publik
                    </a>
                    <a href="{{ url('permohonan-informasi/tracking') }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                        <i class="fa fa-search"></i> Cek Tracking
                    </a>
                </div>
            </div>

            {!! Form::open(['url' => 'dashboard/permohonan-informasi/deleteall', 'method' => 'post', 'id' => 'formDeleteAll']) !!}
            <div class="table-wrapper">
                <table class="table display responsive nowrap table-hover" id="permohonan-table" style="width:100%;">
                    <thead>
                    <tr>
                        <th style="text-align:center;" width="15"></th>
                        <th width="110">No. Tiket</th>
                        <th>Pemohon</th>
                        <th>Informasi Dimohon</th>
                        <th width="100">Status</th>
                        <th width="80" style="text-align:center;">Email Notif</th>
                        <th width="100">Tanggal</th>
                        <th style="text-align:center;" width="100">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td style="text-align:center;">
                            <input type="checkbox" id="titleCheck" data-toggle="tooltip" title="Check All"/>
                        </td>
                        <td colspan="7">
                            <button class="btn btn-sm btn-danger" type="button" onclick="confirmDeleteSelected()">
                                <i class="fa fa-trash-o"></i> Hapus yang Dipilih
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
                columns: [
                    {data: 'check', name: 'check', orderable: false, searchable: false},
                    {data: 'nomor_tiket', name: 'nomor_tiket'},
                    {data: 'pemohon', name: 'nama_pemohon'},
                    {data: 'rincian_informasi', name: 'rincian_informasi'},
                    {data: 'status', name: 'status'},
                    {data: 'notif_email', name: 'notif_email', orderable: false, searchable: false, className: 'text-center'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
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
                $('.btn-filter').removeClass('active');
                $('.btn-filter[data-status="' + status + '"]').addClass('active');
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

