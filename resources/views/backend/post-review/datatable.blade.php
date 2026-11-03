@extends('layouts.backend')
@section('title', 'Manage Reviews')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Reviews</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-star-outline"></i>
        <div>
            <h4>Guest Reviews</h4>
            <p class="mg-b-0">Manage and moderate visitor reviews</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            {!! Form::open(['url' => 'dashboard/post-review/deleteall', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <div class="table-wrapper">
                <table class="table display responsive nowrap" id="post-review-table">
                    <thead>
                    <tr>
                        <th style="text-align:center;" width="15"></th>
                        <th width="30">ID</th>
                        <th>Destinasi / Post</th>
                        <th>Pengulas (Guest)</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th width="120">Actions</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td style="width:10px;" style="text-align:center;">
                            <input type="checkbox" id="titleCheck" data-toggle="tooltip" title="Check All"/>
                        </td>
                        <td colspan="7">
                            <button class="btn btn-sm btn-danger" type="button" data-toggle="modal"
                                    data-target="#alertalldel"><i class="fa fa-trash-o"></i> Delete Selected
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
            $('#post-review-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: -1
                    }
                },
                ajax: '{{ url("dashboard/post-review/data") }}',
                autoWidth: false,
                order: [[1, 'desc']],
                columnDefs: [{
                    targets: 0,
                    orderable: false
                }, {
                    className: 'control',
                    orderable: false,
                    targets: -1
                }],
                columns: [
                    {data: 'check', name: 'check', orderable: false, searchable: false},
                    {data: 'id', name: 'post_reviews.id'},
                    {data: 'post_title', name: 'posts.title'},
                    {data: 'guest_name', name: 'post_reviews.guest_name'},
                    {data: 'rating', name: 'post_reviews.rating'},
                    {data: 'status_badge', name: 'status_badge', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    {data: 'id', name: 'post_reviews.id', orderable: false, searchable: false, visible: false}
                ],
                drawCallback: function (settings) {
                    $("#titleCheck").click(function () {
                        var checkedStatus = this.checked;
                        $("table tbody tr td div:first-child input[type=checkbox]").each(function () {
                            this.checked = checkedStatus;
                        });
                    });
                    deleter.init();
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
