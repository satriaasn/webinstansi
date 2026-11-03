@extends('layouts.backend')
@section('title', $module['title'])

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">{{ $module['title'] }}</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-folder-outline"></i>
        <div>
            <h4>{{ $module['title'] }}</h4>
            <p class="mg-b-0">Kelola dataset Dishub Lampung</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="d-flex justify-content-between align-items-center mg-b-20">
                <a href="{{ url('dashboard/dishub/' . $module['slug'] . '/create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Tambah Data
                </a>
            </div>

            <form action="{{ url('dashboard/dishub/' . $module['slug'] . '/deleteall') }}" method="post" class="form-horizontal">
                @csrf
                <input type="hidden" name="totaldata" id="totaldata" value="0"/>
                <div class="table-wrapper">
                    <table class="table display responsive nowrap" id="dishub-table">
                        <thead>
                        <tr>
                            <th style="text-align:center;" width="15"></th>
                            @foreach($module['columns'] as $column)
                                <th>{{ $column['label'] }}</th>
                            @endforeach
                            <th style="text-align:center;" width="120">Actions</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <td>
                                <input type="checkbox" id="titleCheck" data-toggle="tooltip" title="Check All"/>
                            </td>
                            <td colspan="2">
                                <button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#alertalldel">
                                    <i class="fa fa-trash-o"></i> Delete Selected
                                </button>
                            </td>
                            <td colspan="{{ count($module['columns']) }}"></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            var columns = [
                {data: 'check', name: 'check', orderable: false, searchable: false},
                @foreach($module['columns'] as $column)
                {data: '{{ $column['data'] }}', name: '{{ $column['name'] }}'},
                @endforeach
                {data: 'action', name: 'action', orderable: false, searchable: false},
                {data: 'control', name: 'control', orderable: false, searchable: false}
            ];

            $('#dishub-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: -1
                    }
                },
                ajax: '{{ url("dashboard/dishub/" . $module["slug"] . "/data") }}',
                autoWidth: false,
                order: [[1, 'asc']],
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: -1
                }],
                columns: columns,
                drawCallback: function () {
                    $("#titleCheck").click(function () {
                        var checkedStatus = this.checked;
                        $("table tbody tr td div:first-child input[type=checkbox]").each(function () {
                            this.checked = checkedStatus;
                            $(this).closest('table tbody tr').toggleClass('selected', this.checked);
                            $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
                            $('#totaldata').val($('form input[type=checkbox]:checked').length);
                        });
                    });

                    $('table tbody tr td div:first-child input[type=checkbox]').on('click', function () {
                        $(this).closest('table tbody tr').toggleClass('selected', this.checked);
                        $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
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
        });
    </script>
@endpush
