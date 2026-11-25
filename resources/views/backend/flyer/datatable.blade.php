@extends('layouts.backend')
@section('title', 'Flyer & Ucapan')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Flyer & Ucapan</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-photos-outline"></i>
        <div>
            <h4>Flyer & Ucapan Hari Besar</h4>
            <p class="mg-b-0">Kelola flyer ucapan hari besar & informasi yang tampil di Beranda</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/flyer/create') }}" class="btn btn-success btn-sm"
                       title="Tambah Flyer Baru"><i class="fa fa-plus"></i> Tambah <span class="hidden-xs-down">Flyer</span></a>
                </div>
            </div>

            {!! Form::open(['url' => 'dashboard/flyer/deleteall', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <input type="hidden" name="totaldata" id="totaldata" value="0"/>
            <div class="table-wrapper">
                <table class="table display responsive nowrap" id="flyer-table">
                    <thead>
                    <tr>
                        <th style="text-align:center;" width="15"></th>
                        <th style="text-align:center;" width="25">ID</th>
                        <th>Preview</th>
                        <th>Judul Flyer / Ucapan</th>
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
                        <td colspan="5"></td>
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
            $('#flyer-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: -1
                    }
                },
                ajax: '{{ url("dashboard/flyer/data") }}',
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
                    {data: 'id', name: 'flyers.id'},
                    {data: 'picture_preview', name: 'picture_preview', orderable: false, searchable: false},
                    {data: 'title', name: 'flyers.title'},
                    {data: 'active', name: 'flyers.active'},
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
