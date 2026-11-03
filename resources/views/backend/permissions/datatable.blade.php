@extends('layouts.backend')
@section('title', 'Permissions')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Permissions</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-contact-outline"></i>
        <div>
            <h4>Permissions</h4>
            <p class="mg-b-0">List Permissions</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/permissions/create') }}" class="btn btn-success btn-sm"
                       title="Add New Permission"><i class="fa fa-plus"></i> Add <span class="hidden-xs-down">New</span></a>
                </div>
            </div>

            {!! Form::open(['url' => 'dashboard/permissions/deleteall', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <input type="hidden" name="totaldata" id="totaldata" value="0"/>
            <div class="table-wrapper">
                <table class="table display responsive nowrap" id="permissions-table">
                    <thead>
                    <tr>
                        <th style="text-align:center;" width="15"></th>
                        <th style="text-align:center;" width="25">ID</th>
                        <th>Name</th>
                        <th>Label</th>
                        <th>Create By</th>
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
