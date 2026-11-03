@extends('layouts.backend')
@section('title', 'Theme')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Theme</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-color-filter-outline"></i>
        <div>
            <h4>Theme</h4>
            <p class="mg-b-0">List Theme</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            {!! Form::open(['url' => 'dashboard/theme/deleteall', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <input type="hidden" name="totaldata" id="totaldata" value="0"/>
            <div class="table-wrapper">
                <table class="table display responsive nowrap" id="theme-table">
                    <thead>
                    <tr>
                        <th style="text-align:center;" width="25">ID</th>
                        <th>Preview</th>
                        <th>Title</th>
                        <th>Active</th>
                        <th style="text-align:center;">Create By</th>
                        <th style="text-align:center;" width="120">Actions</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            var table = $('#theme-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: -1
                    }
                },
                ajax: '{{ url("dashboard/theme/data") }}',
                autoWidth: false,
                order: [[0, 'desc']],
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: -1
                }],
                columns: [
                    {data: 'id', name: 'themes.id'},
                    {data: 'picture', name: 'themes.picture'},
                    {data: 'title', name: 'themes.title'},
                    {data: 'active', name: 'themes.active'},
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
                    $('.btn-active').click(function () {
                        var id = $(this).attr("id");
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            url: "{{ url('/dashboard/theme/active') }}",
                            data: 'id=' + id,
                            cache: false,
                            success: function () {
                                table.ajax.reload();
                            }
                        });
                        return false;
                    });
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
