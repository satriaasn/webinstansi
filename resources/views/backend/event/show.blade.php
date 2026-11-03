@extends('layouts.backend')
@section('title', 'View Event')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/event') }}">Event</a>
            <span class="breadcrumb-item active">View Event</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/event/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th> Nama Event</th>
                        <td> {{ $event->event_nama }} </td>
                    </tr>
                    <tr>
                        <th> SEO Event</th>
                        <td> {{ $event->event_seo }} </td>
                    </tr>
                    <tr>
                        <th> Tanggal Mulai</th>
                        <td> {{ \Carbon\Carbon::parse($event->event_tanggalmulai)->format('d/m/Y')}} </td>
                    </tr>
                    <tr>
                        <th> Tanggal Selesai</th>
                        <td> {{ \Carbon\Carbon::parse($event->event_tanggalselesai)->format('d/m/Y')}} </td>
                    </tr>
                    <tr>
                        <th> Lokasi Event</th>
                        <td> {{ $event->event_lokasi }} </td>
                    </tr>
                    <tr>
                        <th> Penyelenggara</th>
                        <td> {{ $event->event_penyelenggara }} </td>
                    </tr>
                    <tr>
                        <th> Kontak</th>
                        <td> {{ $event->event_kontak }} </td>
                    </tr>
                    <tr>
                        <th> Deskripsi</th>
                        <td> {!! $event->event_deskripsi !!} </td>
                    </tr>

                    @if(!empty($event->event_link_terkait))
                        <tr>
                            <th> Link terkait</th>
                            <td> {{ $event->event_link_terkait }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th> Active</th>
                        <td> {{ $event->event_status == 'Y' ? 'Active' : 'Non Active' }} </td>
                    </tr>
                    @if(!empty($event->event_gambar))
                        <tr>
                            <th> Gambar</th>
                            <td><a href="{{ berkas( $event->event_gambar) }}"
                                   id="quickview">{{ $event->event_gambar }}</a></td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="jumbotron">Upload Gallery <i class="fa fa-image"></i></h3>
            <form method="post" action="{{url('dashboard/event/store_image')}}" enctype="multipart/form-data">
                {{csrf_field()}}

                <input type="hidden" id="event_kode" name="event_kode" value="{{ $event->event_kode }}">
                <div class="input-group control-group increment">
                    <input type="file" name="event_picture[]" class="form-control">
                    <div class="input-group-btn">
                        <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add
                        </button>
                    </div>
                </div>
                <div class="clone hide">
                    <div class="control-group input-group" style="margin-top:10px">
                        <input type="file" name="event_picture[]" class="form-control" accept="image/*">
                        <div class="input-group-btn">
                            <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i>
                                Remove
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top:10px; margin-bottom: 20px"><i
                        class="fa fa-upload"></i> Upload
                </button>

            </form>


            {!! Form::open(['url' => 'dashboard/event/deleteallgallery', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <input type="hidden" name="totaldata" id="totaldata" value="0"/>
            <div class="table-wrapper">
                <table class="table display responsive nowrap" id="event-table">
                    <thead>
                    <tr>
                        <th style="text-align:center;" width="15"></th>
                        <th>Picture</th>
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
                        <td colspan="1"></td>
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

        $(document).ready(function () {

            var table = $('#event-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: -1
                    }
                },
                "ajax": {
                    "url": "{{ url("dashboard/event/dataGallery/".$event->event_kode) }}",
                    "type": "GET"
                },
                {{--ajax: '{{ url("dashboard/event/dataGallery/".$event->event_kode) }}',--}}
                autoWidth: false,
                order: [[2, 'asc']],
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
                    {data: 'event_picture', name: 'event_picture'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    // { data: 'event_kode', name: 'event_kode' },
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

            $(".btn-success").click(function () {
                var html = $(".clone").html();
                $(".increment").after(html);
            });

            $("body").on("click", ".btn-danger", function () {
                $(this).parents(".control-group").remove();
            });

        });

    </script>
@endpush

