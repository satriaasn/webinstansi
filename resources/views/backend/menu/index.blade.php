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
            <h4>Struktur Menu Website</h4>
            <p class="mg-b-0">Atur hierarki menu utama dan dropdown submenu navigasi website</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            
            <!-- Top Controls & Action -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5 pb-4 border-b border-slate-100">
                <div class="card-options m-0">
                    <a href="javascript:void(0);" class="btn btn-success btn-sm" title="Tambah Menu Baru"
                       data-toggle="modal" data-target="#form-add">
                        <i class="fa fa-plus"></i> Tambah Menu Baru
                    </a>
                </div>

                <!-- Info Hint -->
                <div class="text-[11px] text-slate-500 bg-blue-50 border border-blue-100 rounded-xl px-3 py-2 flex items-center gap-2">
                    <i class="fas fa-info-circle text-[#1A56DB] text-xs"></i>
                    <span>Tahan ikon grip <i class="fas fa-grip-vertical text-slate-400"></i> lalu geser ke kanan untuk mengubahnya menjadi <strong>Submenu</strong>.</span>
                </div>
            </div>

            <!-- Save Success Indicator -->
            <div id="success-indicator" class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 mb-4 shadow-sm" style="display:none;">
                <i class="fas fa-check-circle text-emerald-600 text-sm"></i> Susunan hierarki menu berhasil diperbarui dan disimpan otomatis!
            </div>

            <!-- Nestable Tree Structure -->
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
            </div>

        </div>
    </div>

    <!-- Modal Tambah Menu Baru -->
    <div id="form-add" tabindex="-1" role="dialog" class="modal" style="display: none !important;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {!! Form::open(['url' => 'dashboard/menu', 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="modal-header px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#1A56DB] flex items-center justify-center text-xs">
                            <i class="fas fa-plus"></i>
                        </div>
                        <h5 class="text-sm font-black text-slate-800 m-0">Tambah Menu Navigasi</h5>
                    </div>
                    <button type="button" class="close text-slate-400 hover:text-slate-700 text-lg leading-none p-1 focus:outline-none" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <div class="modal-body p-6 space-y-4">
                    <div>
                        <label class="required font-bold text-xs text-slate-700 block mb-1">Nama Menu</label>
                        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Contoh: Profil, Agenda, Dokumen']) !!}
                    </div>
                    <div>
                        <label class="required font-bold text-xs text-slate-700 block mb-1">Tautan URL</label>
                        {!! Form::text('url', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Contoh: pages/tentang-kami atau https://...']) !!}
                    </div>
                    <div>
                        <label class="required font-bold text-xs text-slate-700 block mb-1">Target Jendela</label>
                        <select class="target form-control" id="target" name="target">
                            <option value="none">none (Buka di tab yang sama)</option>
                            <option value="_blank">_blank (Buka di tab baru)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-2 bg-slate-50/50">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary btn-sm px-4">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm px-5">Simpan Menu</button>
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

            if (typeof $.fn.nestable !== 'undefined') {
                $('#nestable').nestable({
                    maxDepth: 4,
                    group: 1
                }).on('change', updateOutput);

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
                            $("#success-indicator").fadeIn(200);
                            setTimeout(function() {
                                $("#success-indicator").fadeOut(400);
                            }, 3500);
                        }
                    });
                });
            }

            $('.select2').select2({minimumResultsForSearch: Infinity});
        });
    </script>
@endpush
