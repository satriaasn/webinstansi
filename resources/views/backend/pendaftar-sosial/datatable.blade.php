@extends('layouts.backend')
@section('title', 'Pendaftar Layanan Sosial')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Pendaftar Layanan Sosial</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-people-outline"></i>
        <div>
            <h4>Pendaftar Layanan Sosial</h4>
            <p class="mg-b-0">Daftar Pendaftar Layanan Sosial Dinas Sosial Provinsi Lampung</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            {!! Form::open(['url' => 'dashboard/pendaftar-sosial/deleteall', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <input type="hidden" name="totaldata" id="totaldata" value="0"/>
            <div class="table-wrapper">
                <table class="table display responsive nowrap" id="pendaftar-table">
                    <thead>
                    <tr>
                        <th style="text-align:center;" width="15"></th>
                        <th>Kode/No. Reg</th>
                        <th>Tgl Daftar</th>
                        <th>Layanan</th>
                        <th>Nama Pemohon</th>
                        <th>NIK</th>
                        <th>Status</th>
                        <th style="text-align:center;" width="120">Actions</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td style="width:10px;" style="text-align:center;">
                            <input type="checkbox" id="titleCheck" data-toggle="tooltip" title="Check All"/>
                        </td>
                        <td colspan="2">
                            <button class="btn btn-sm btn-danger" type="button" data-toggle="modal"
                                    data-target="#alertalldel"><i class="fa fa-trash-o"></i> Delete Selected
                            </button>
                        </td>
                        <td colspan="6"></td>
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
            var table = $('#pendaftar-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: -1
                    }
                },
                ajax: '{{ url("dashboard/pendaftar-sosial/data") }}',
                autoWidth: false,
                order: [[2, 'desc']], // Sort by Tgl Daftar desc
                columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }, {
                    className: 'control',
                    orderable: false,
                    targets: -1
                }],
                columns: [
                    {data: 'check', name: 'check', orderable: false, searchable: false},
                    {data: 'nomor_registrasi', name: 'nomor_registrasi'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'layanan_nama', name: 'layanan.nama'},
                    {data: 'nama_lengkap', name: 'nama_lengkap'},
                    {data: 'nik', name: 'nik'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    {data: 'control', name: 'control', orderable: false, searchable: false},
                ],
                drawCallback: function (settings) {
                    $("#titleCheck").click(function () {
                        var checkedStatus = this.checked;
                        $("table tbody tr td div:first-child input[type=checkbox]").each(function () {
                            this.checked = checkedStatus;
                            if (checkedStatus == this.checked) {
                                $(this).closest('table tbody tr').removeClass('selected');
                                $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
                                $('#totaldata').val($('form input[type=checkbox]:checked').length);
                            }
                            if (this.checked) {
                                $(this).closest('table tbody tr').addClass('selected');
                                $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
                                $('#totaldata').val($('form input[type=checkbox]:checked').length);
                            }
                        });
                    });
                    $('table tbody tr td div:first-child input[type=checkbox]').on('click', function () {
                        var checkedStatus = this.checked;
                        this.checked = checkedStatus;
                        if (checkedStatus == this.checked) {
                            $(this).closest('table tbody tr').removeClass('selected');
                            $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
                            $('#totaldata').val($('form input[type=checkbox]:checked').length);
                        }
                        if (this.checked) {
                            $(this).closest('table tbody tr').addClass('selected');
                            $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
                            $('#totaldata').val($('form input[type=checkbox]:checked').length);
                        }
                    });
                    $('table tbody tr td div:first-child input[type=checkbox]').change(function () {
                        $(this).closest('tr').toggleClass("selected", this.checked);
                    });
                    deleter.init();
                    $('[data-toggle="tooltip"]').tooltip();
                },
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });

            $('.dataTables_length select').select2({minimumResultsForSearch: Infinity});
        });
    </script>
@endpush
