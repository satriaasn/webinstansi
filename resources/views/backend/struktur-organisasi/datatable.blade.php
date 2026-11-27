@extends('layouts.backend')
@section('title', 'Struktur Organisasi')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Struktur Organisasi</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="fas fa-sitemap text-blue-600"></i>
        <div>
            <h4>Struktur Organisasi</h4>
            <p class="mg-b-0">Kelola bagan jabatan, pejabat, foto, dan hierarki organisasi secara dinamis.</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-20 d-flex justify-content-between align-items-center flex-wrap" style="gap: 10px;">
                <div class="card-options d-flex align-items-center flex-wrap" style="gap: 8px;">
                    <a href="{{ url('dashboard/struktur-organisasi/create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Tambah Jabatan
                    </a>
                    <a href="{{ url('struktur-organisasi') }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fa fa-external-link"></i> Lihat Bagan Interaktif
                    </a>
                </div>
                <div class="d-flex align-items-center" style="gap: 8px;">
                    <label for="filter-active" class="mb-0 tx-12 font-weight-bold text-secondary">Filter Status:</label>
                    <select id="filter-active" class="form-control form-control-sm" style="width: 150px;">
                        <option value="">Semua Status</option>
                        <option value="Y">Active</option>
                        <option value="N">Non Active</option>
                    </select>
                </div>
            </div>

            {!! Form::open(['url' => 'dashboard/struktur-organisasi/deleteall', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <input type="hidden" name="totaldata" id="totaldata" value="0"/>
            <div class="table-wrapper">
                <table class="table display responsive nowrap" id="struktur-table">
                    <thead>
                    <tr>
                        <th style="text-align:center;" width="15"></th>
                        <th style="text-align:center;" width="25">ID</th>
                        <th width="50">Foto</th>
                        <th>Jabatan</th>
                        <th>Pejabat &amp; NIP</th>
                        <th>Atasan / Parent</th>
                        <th style="text-align:center;" width="60">Urutan</th>
                        <th>Active</th>
                        <th style="text-align:center;" width="120">Actions</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td style="width:10px;text-align:center;">
                            <input type="checkbox" id="titleCheck" data-toggle="tooltip" title="Check All"/>
                        </td>
                        <td colspan="3">
                            <button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#alertalldel">
                                <i class="fa fa-trash-o"></i> Delete Selected
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
    var table = $('#struktur-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: { details: { type: 'column', target: -1 } },
        ajax: {
            url: '{{ url("dashboard/struktur-organisasi/data") }}',
            data: function (d) {
                d.active = $('#filter-active').val();
            }
        },
        autoWidth: false,
        order: [[1, 'asc']],
        columnDefs: [
            { targets: 'no-sort', orderable: false },
            { className: 'control', orderable: false, targets: -1 }
        ],
        columns: [
            {data: 'check', name: 'check', orderable: false, searchable: false},
            {data: 'id', name: 'struktur_organisasis.id'},
            {data: 'foto_preview', name: 'foto_preview', orderable: false, searchable: false},
            {data: 'jabatan', name: 'struktur_organisasis.jabatan'},
            {data: 'pejabat_info', name: 'struktur_organisasis.nama'},
            {data: 'parent_info', name: 'parents.jabatan'},
            {data: 'urutan', name: 'struktur_organisasis.urutan'},
            {data: 'active', name: 'struktur_organisasis.active'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'control', name: 'control', orderable: false, searchable: false},
        ],
        drawCallback: function () {
            $("#titleCheck").off('click').on('click', function () {
                var checkedStatus = this.checked;
                $("table tbody tr td div:first-child input[type=checkbox]").each(function () {
                    this.checked = checkedStatus;
                    $(this).closest('table tbody tr').toggleClass('selected', checkedStatus);
                    $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !checkedStatus);
                });
                $('#totaldata').val($('form input[type=checkbox]:checked').length);
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

    $('#filter-active').on('change', function () {
        table.ajax.reload();
    });
});
</script>
@endpush
