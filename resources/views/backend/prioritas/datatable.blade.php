@extends('layouts.backend')
@section('title', 'Prioritas Pembangunan')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Prioritas Pembangunan</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-list-outline"></i>
        <div>
            <h4>Prioritas Pembangunan</h4>
            <p class="mg-b-0">Kelola Daftar Prioritas Pembangunan yang tampil di Beranda</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/prioritas/create') }}" class="btn btn-success btn-sm"
                       title="Tambah Prioritas Baru"><i class="fa fa-plus"></i> Tambah <span class="hidden-xs-down">Prioritas</span></a>
                </div>
            </div>

            {!! Form::open(['url' => 'dashboard/prioritas/deleteall', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <input type="hidden" name="totaldata" id="totaldata" value="0"/>
            <div class="table-wrapper">
                <table class="table display responsive nowrap" id="prioritas-table">
                    <thead>
                    <tr>
                        <th style="text-align:center;" width="15"></th>
                        <th style="text-align:center;" width="25">Urutan</th>
                        <th>Judul Prioritas</th>
                        <th>Status</th>
                        <th style="text-align:center;">Dibuat Oleh</th>
                        <th style="text-align:center;" width="120">Actions</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td style="width:10px;text-align:center;">
                            <input type="checkbox" id="titleCheck" data-toggle="tooltip" title="Check All"/>
                        </td>
                        <td colspan="2">
                            <button class="btn btn-sm btn-danger" type="button" data-toggle="modal"
                                    data-target="#alertalldel"><i class="fa fa-trash-o"></i> Delete Selected
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
            $('#prioritas-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: -1
                    }
                },
                ajax: '{{ url("dashboard/prioritas/data") }}',
                autoWidth: false,
                order: [[1, 'asc']],
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
                    {data: 'urutan', name: 'prioritas_pembangunans.urutan'},
                    {data: 'title', name: 'prioritas_pembangunans.title'},
                    {data: 'active', name: 'prioritas_pembangunans.active'},
                    {data: 'uname', name: 'users.name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    {data: 'control', name: 'control', orderable: false, searchable: false},
                ],
                drawCallback: function () {
                    $("#titleCheck").click(function () {
                        var checkedStatus = this.checked;
                        $("table tbody tr td div:first-child input[type=checkbox]").each(function () {
                            this.checked = checkedStatus;
                            var checked = $(this).is(':checked');
                            if (checked) {
                                $(this).closest('div').find('.deldata').prop('disabled', false);
                            } else {
                                $(this).closest('div').find('.deldata').prop('disabled', true);
                            }
                        });
                    });
                }
            });
        });
    </script>
@endpush
