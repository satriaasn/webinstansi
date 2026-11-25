@extends('layouts.backend')
@section('title', 'Keberatan Informasi Masuk (PPID)')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Keberatan Informasi (PPID)</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-information-outline"></i>
        <div>
            <h4>Keberatan Atas Permohonan Informasi</h4>
            <p class="mg-b-0">Kelola pengajuan keberatan informasi publik PPID Bappeda</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-20 d-flex justify-content-between align-items-center">
                <a href="{{ url('keberatan-informasi') }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="fa fa-external-link"></i> Lihat Form Publik
                </a>
            </div>

            {!! Form::open(['url' => 'dashboard/keberatan-informasi/deleteall', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <input type="hidden" name="totaldata" id="totaldata" value="0"/>
            <div class="table-wrapper">
                <table class="table display responsive nowrap" id="keberatan-table">
                    <thead>
                    <tr>
                        <th style="text-align:center;" width="15"></th>
                        <th>No. Registrasi</th>
                        <th>No. Permohonan</th>
                        <th>Nama Pengaju</th>
                        <th>No. Telepon</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th style="text-align:center;" width="140">Aksi</th>
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
            $('#keberatan-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: -1
                    }
                },
                ajax: '{{ url("dashboard/keberatan-informasi/data") }}',
                autoWidth: false,
                order: [[0, 'desc']],
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
                    {data: 'nomor_registrasi_keberatan', name: 'nomor_registrasi_keberatan'},
                    {data: 'nomor_permohonan_informasi', name: 'nomor_permohonan_informasi'},
                    {data: 'nama', name: 'nama'},
                    {data: 'nomor_telepon', name: 'nomor_telepon'},
                    {data: 'tanggal_fmt', name: 'created_at'},
                    {data: 'status_badge', name: 'status'},
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
