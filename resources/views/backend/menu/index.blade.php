@extends('layouts.backend')
@section('title', 'Menu Manager')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Menu Manager</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-grid"></i>
        <div>
            <h4>Menu Manager</h4>
            <p class="mg-b-0">List Menu Manager</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="javascript:void(0);" class="btn btn-success btn-sm" title="Add New Menu Manager"
                       data-toggle="modal" data-target="#form-add"><i class="fa fa-plus"></i> Add <span
                            class="hidden-xs-down">New</span></a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" id="nestable-output"/>
                    <div class="dd" id="nestable" style="max-width: 100%!important;">
                        <ol class="dd-list">
                            @if(count($menu) > 0)
                                @each('backend.menu.menu', $menu, 'menu', 'backend.menu.menu')
                            @endif
                        </ol>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="success-indicator" class="alert alert-success mg-20" role="alert" style="display:none;">
                        <i class="fa fa-check"></i> Menu order has been saved
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="form-add" tabindex="-1" role="dialog" class="modal">
        <div class="modal-dialog modal-dialog-centered bd-0" role="document">
            <div class="modal-content">
                {!! Form::open(['url' => 'dashboard/menu', 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add New</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required">Name</label>
                                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required">Url</label>
                                {!! Form::text('url', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required">Target</label>
                                <select class="target form-control" id="target" name="target">
                                    <option value="none">none</option>
                                    <option value="_blank">_blank</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            var updateOutput = function (e) {
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };

            $('#nestable').nestable().on('change', updateOutput);

            updateOutput($('#nestable').data('output', $('#nestable-output')));

            $('.dd').on('change', function () {
                $("#success-indicator").hide();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var dataString = {
                    data: $("#nestable-output").val(),
                    _token: CSRF_TOKEN
                };
                $.ajax({
                    type: 'POST',
                    url: '{{ url("dashboard/menu/menusort") }}',
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        $("#success-indicator").show();
                    }
                });
            });

            $('.select2').select2({minimumResultsForSearch: Infinity});
        });
    </script>
@endpush
