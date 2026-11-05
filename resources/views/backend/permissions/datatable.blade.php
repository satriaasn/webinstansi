@extends('layouts.backend')
@section('title', 'Hak Akses & Permissions')

@section('content')
    <div class="br-pageheader font-sans">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item">Pengguna</span>
            <span class="breadcrumb-item active">Permissions</span>
        </nav>
    </div>

    <!-- Header & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 font-sans">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-blue-50 text-[#1A56DB] flex items-center justify-center text-xl shadow-xs flex-shrink-0">
                <i class="fas fa-key"></i>
            </div>
            <div>
                <h1 class="text-lg sm:text-xl font-black text-slate-800 m-0 leading-tight">Izin Akses (Permissions)</h1>
                <p class="text-xs text-slate-500 m-0 mt-0.5">Kelola daftar hak akses permission granular untuk modul dan fitur sistem</p>
            </div>
        </div>
        <div>
            <a href="{{ url('dashboard/permissions/create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#1A56DB] hover:bg-blue-700 text-white text-xs font-bold transition shadow-xs text-decoration-none">
                <i class="fas fa-plus text-xs"></i> Tambah Permission Baru
            </a>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper font-sans">
            {!! Form::open(['url' => 'dashboard/permissions/deleteall', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <input type="hidden" name="totaldata" id="totaldata" value="0"/>
            <div class="table-wrapper">
                <table class="table display responsive nowrap w-full" id="permissions-table">
                    <thead>
                    <tr>
                        <th style="text-align:center;" width="15"></th>
                        <th style="text-align:center;" width="40">ID</th>
                        <th>Name</th>
                        <th>Label</th>
                        <th>Create By</th>
                        <th style="text-align:center;" width="120">Actions</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td style="width:10px; text-align:center;">
                            <input type="checkbox" id="titleCheck" data-toggle="tooltip" title="Pilih Semua"/>
                        </td>
                        <td colspan="2">
                            <button class="btn btn-sm btn-danger inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold" type="button" data-toggle="modal"
                                    data-target="#alertalldel"><i class="fas fa-trash-alt text-xs"></i> Hapus Terpilih
                            </button>
                        </td>
                        <td colspan="4"></td>
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
            var table = $('#permissions-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: -1
                    }
                },
                ajax: '{{ url("dashboard/permissions/data") }}',
                autoWidth: false,
                order: [[1, 'desc']],
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
                    {data: 'id', name: 'permissions.id'},
                    {data: 'name', name: 'permissions.name'},
                    {data: 'label', name: 'permissions.label'},
                    {data: 'uname', name: 'users.name'},
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
                                $('#totaldata').val($('form input[type=checkbox]:checked').size());
                            }
                            if (this.checked) {
                                $(this).closest('table tbody tr').addClass('selected');
                                $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
                                $('#totaldata').val($('form input[type=checkbox]:checked').size());
                            }
                        });
                    });
                    $('table tbody tr td div:first-child input[type=checkbox]').on('click', function () {
                        var checkedStatus = this.checked;
                        this.checked = checkedStatus;
                        if (checkedStatus == this.checked) {
                            $(this).closest('table tbody tr').removeClass('selected');
                            $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
                            $('#totaldata').val($('form input[type=checkbox]:checked').size());
                        }
                        if (this.checked) {
                            $(this).closest('table tbody tr').addClass('selected');
                            $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
                            $('#totaldata').val($('form input[type=checkbox]:checked').size());
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
