@extends('layouts.backend')
@section('title', 'Struktur Menu Website')

@section('content')
    <div class="br-pageheader font-sans">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Struktur Menu Website</span>
        </nav>
    </div>

    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 font-sans">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-blue-50 text-[#1A56DB] flex items-center justify-center text-xl shadow-xs flex-shrink-0">
                <i class="fas fa-sitemap"></i>
            </div>
            <div>
                <h1 class="text-lg sm:text-xl font-black text-slate-800 m-0 leading-tight">Struktur & Hierarki Menu</h1>
                <p class="text-xs text-slate-500 m-0 mt-0.5">
                    Susun tata letak navigasi utama dan hierarki submenu website dengan drag and drop atau tombol cepat
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <button type="button" id="btn-expand-all" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition shadow-xs">
                <i class="fas fa-angles-down text-[11px]"></i> Expand Semua
            </button>
            <button type="button" id="btn-collapse-all" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition shadow-xs">
                <i class="fas fa-angles-up text-[11px]"></i> Collapse Semua
            </button>
            <a href="javascript:void(0);" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#1A56DB] hover:bg-blue-700 text-white text-xs font-bold transition shadow-xs text-decoration-none"
               data-toggle="modal" data-target="#form-add">
                <i class="fas fa-plus text-xs"></i> Tambah Menu Baru
            </a>
        </div>
    </div>

    <!-- Interactive Guide Card -->
    <div class="p-4 rounded-2xl bg-blue-50/70 border border-blue-200/80 mb-5 font-sans">
        <div class="flex items-start gap-3">
            <div class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs flex-shrink-0 mt-0.5">
                <i class="fas fa-lightbulb"></i>
            </div>
            <div class="text-xs text-slate-700 space-y-1.5 leading-relaxed">
                <div class="font-extrabold text-slate-900">Cara Mengatur Hierarki Menu (Submenu):</div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-[11px] text-slate-600">
                    <div class="flex items-center gap-2 bg-white/80 p-2.5 rounded-xl border border-blue-100">
                        <i class="fas fa-arrows-up-down-left-right text-[#1A56DB] text-sm"></i>
                        <span><strong>Metode 1 (Drag & Drop):</strong> Tahan ikon grip pada sisi kiri kartu menu, lalu geser ke <strong>kanan</strong> untuk menjadikannya Submenu, atau geser ke <strong>kiri</strong> untuk mengeluarkannya ke Menu Utama.</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/80 p-2.5 rounded-xl border border-blue-100">
                        <i class="fas fa-arrow-right text-emerald-600 text-sm"></i>
                        <span><strong>Metode 2 (Tombol Cepat):</strong> Klik tombol panah <span class="px-1.5 py-0.5 bg-slate-200 text-slate-800 rounded font-bold">→</span> untuk langsung menjadikannya Submenu dari menu di atasnya, atau tombol <span class="px-1.5 py-0.5 bg-slate-200 text-slate-800 rounded font-bold">←</span> untuk kembali.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Indicators -->
    <div id="saving-indicator" class="p-3.5 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-xs font-semibold flex items-center gap-2 mb-4 shadow-sm" style="display:none;">
        <i class="fas fa-circle-notch fa-spin text-[#1A56DB] text-sm"></i> Sedang menyimpan perubahan susunan dan hierarki menu...
    </div>

    <div id="success-indicator" class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 mb-4 shadow-sm" style="display:none;">
        <i class="fas fa-check-circle text-emerald-600 text-sm"></i> Susunan dan hierarki menu berhasil diperbarui dan tersimpan otomatis!
    </div>

    <div id="error-indicator" class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center gap-2 mb-4 shadow-sm" style="display:none;">
        <i class="fas fa-circle-exclamation text-rose-600 text-sm"></i> <span id="error-text">Terjadi kesalahan saat menyimpan susunan menu. Silakan coba lagi.</span>
    </div>

    <!-- Nestable Tree Structure -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 font-sans">
        <input type="hidden" id="nestable-output"/>
        <div class="dd" id="nestable" style="max-width: 100%!important;">
            <ol class="dd-list">
                @if(count($menu) > 0)
                    @foreach($menu as $item)
                        @include('backend.menu.menu', ['menu' => $item])
                    @endforeach
                @else
                    <div class="p-8 text-center text-slate-400">
                        <i class="fas fa-folder-open text-3xl mb-2 block"></i>
                        <p class="text-sm font-semibold m-0">Belum ada menu yang dibuat. Klik tombol "Tambah Menu Baru" di atas.</p>
                    </div>
                @endif
            </ol>
        </div>
    </div>

    <!-- Modal Tambah Menu Baru -->
    <div id="form-add" tabindex="-1" role="dialog" class="modal" style="display: none !important;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 rounded-2xl shadow-2xl overflow-hidden font-sans">
                {!! Form::open(['url' => 'dashboard/menu', 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="modal-header px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
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
                        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Contoh: Profil, Agenda, Dokumen, Regulasi']) !!}
                    </div>
                    <div>
                        <label class="required font-bold text-xs text-slate-700 block mb-1">Tautan URL</label>
                        {!! Form::text('url', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Contoh: # (jika hanya dropdown induk), pages/tentang-kami, atau https://...']) !!}
                        <small class="text-slate-400 text-[11px] block mt-1">Gunakan <code>#</code> bila menu hanya berfungsi sebagai induk dropdown yang membawahi submenu.</small>
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
            // Function to update visual hierarchy badges dynamically
            function updateMenuBadges() {
                $('#nestable .dd-item').each(function () {
                    var $item = $(this);
                    var depth = $item.parents('.dd-list').length; // 1 = Main Menu, 2 = Submenu, 3+ = Sub-submenu
                    var $badgeContainer = $item.find('> .dd3-content .menu-level-badge');
                    
                    if (depth === 1) {
                        $badgeContainer.html('<span class="inline-flex items-center gap-1 text-[10px] font-extrabold px-2 py-0.5 rounded-md bg-blue-50 text-[#1A56DB] border border-blue-200 uppercase tracking-wider flex-shrink-0"><i class="fas fa-layer-group text-[8px]"></i> Menu Utama</span>');
                    } else if (depth === 2) {
                        $badgeContainer.html('<span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 flex-shrink-0"><i class="fas fa-turn-up rotate-90 text-[8px]"></i> Submenu</span>');
                    } else {
                        $badgeContainer.html('<span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 border border-amber-200 flex-shrink-0"><i class="fas fa-turn-up rotate-90 text-[8px]"></i> Submenu Lvl ' + depth + '</span>');
                    }

                    // Toggle disabled appearance on outdent button
                    var $outdentBtn = $item.find('> .dd3-content .btn-outdent');
                    if (depth <= 1) {
                        $outdentBtn.addClass('opacity-30 cursor-not-allowed').prop('disabled', true);
                    } else {
                        $outdentBtn.removeClass('opacity-30 cursor-not-allowed').prop('disabled', false);
                    }

                    // Toggle disabled appearance on indent button if no previous sibling
                    var $indentBtn = $item.find('> .dd3-content .btn-indent');
                    if ($item.prev('.dd-item').length && depth < 4) {
                        $indentBtn.removeClass('opacity-30 cursor-not-allowed').prop('disabled', false);
                    } else {
                        $indentBtn.addClass('opacity-30 cursor-not-allowed').prop('disabled', true);
                    }
                });
            }

            var saveDebounceTimer = null;
            function triggerMenuSave() {
                updateMenuBadges();

                if (window.JSON) {
                    var serialized = $('#nestable').nestable('serialize');
                    $('#nestable-output').val(window.JSON.stringify(serialized));
                }

                clearTimeout(saveDebounceTimer);
                saveDebounceTimer = setTimeout(function () {
                    $("#saving-indicator").show();
                    $("#success-indicator").hide();
                    $("#error-indicator").hide();

                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    var dataString = {
                        data: $("#nestable-output").val(),
                        _token: CSRF_TOKEN
                    };

                    $.ajax({
                        type: 'POST',
                        url: '{{ url("dashboard/menu/menusort") }}',
                        data: dataString,
                        dataType: 'json',
                        cache: false,
                        success: function (res) {
                            $("#saving-indicator").hide();
                            $("#success-indicator").stop(true, true).fadeIn(200);
                            setTimeout(function() {
                                $("#success-indicator").fadeOut(400);
                            }, 3500);
                        },
                        error: function (xhr) {
                            $("#saving-indicator").hide();
                            var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Gagal menyimpan susunan menu.';
                            $("#error-text").text(msg);
                            $("#error-indicator").stop(true, true).fadeIn(200);
                        }
                    });
                }, 300);
            }

            // Initialize Nestable Plugin
            if (typeof $.fn.nestable !== 'undefined') {
                $('#nestable').nestable({
                    maxDepth: 4,
                    group: 1,
                    threshold: 20
                }).on('change', function () {
                    triggerMenuSave();
                });

                // Initial badge state & buttons
                updateMenuBadges();
            }

            // Quick Hierarchy Button Handlers:
            
            // 1. Indent (Geser ke Kanan menjadi Submenu dari menu di atasnya)
            $(document).on('click', '.btn-indent', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var $item = $(this).closest('.dd-item');
                var $prev = $item.prev('.dd-item');

                if (!$prev.length) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Tidak Dapat Dijadikan Submenu',
                            text: 'Menu ini berada pada urutan paling atas. Geser atau pindahkan di bawah menu lain terlebih dahulu.',
                            timer: 2500,
                            showConfirmButton: false
                        });
                    } else {
                        alert('Menu ini berada pada urutan paling atas. Geser di bawah menu lain terlebih dahulu.');
                    }
                    return;
                }

                var $subList = $prev.children('ol.dd-list');
                if (!$subList.length) {
                    $subList = $('<ol class="dd-list"></ol>');
                    $prev.append($subList);
                    if ($('#nestable').data('nestable')) {
                        $('#nestable').data('nestable').setParent($prev);
                    }
                }
                $subList.append($item);
                triggerMenuSave();
            });

            // 2. Outdent (Geser ke Kiri keluar dari Submenu menjadi Menu Induk)
            $(document).on('click', '.btn-outdent', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var $item = $(this).closest('.dd-item');
                var $parentList = $item.parent('ol.dd-list');
                var $parentItem = $parentList.closest('.dd-item');

                if (!$parentItem.length) {
                    return; // Already top level
                }

                $parentItem.after($item);

                // If parent list is now empty, remove it and unset parent
                if (!$parentList.children('.dd-item').length) {
                    if ($('#nestable').data('nestable')) {
                        $('#nestable').data('nestable').unsetParent($parentItem);
                    } else {
                        $parentList.remove();
                    }
                }

                triggerMenuSave();
            });

            // 3. Move Up (Pindah Urutan Naik)
            $(document).on('click', '.btn-moveup', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var $item = $(this).closest('.dd-item');
                var $prev = $item.prev('.dd-item');
                if ($prev.length) {
                    $prev.before($item);
                    triggerMenuSave();
                }
            });

            // 4. Move Down (Pindah Urutan Turun)
            $(document).on('click', '.btn-movedown', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var $item = $(this).closest('.dd-item');
                var $next = $item.next('.dd-item');
                if ($next.length) {
                    $next.after($item);
                    triggerMenuSave();
                }
            });

            // Expand All and Collapse All buttons
            $('#btn-expand-all').on('click', function () {
                if (typeof $.fn.nestable !== 'undefined') {
                    $('#nestable').nestable('expandAll');
                }
            });

            $('#btn-collapse-all').on('click', function () {
                if (typeof $.fn.nestable !== 'undefined') {
                    $('#nestable').nestable('collapseAll');
                }
            });

            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2({minimumResultsForSearch: Infinity});
            }
        });
    </script>
@endpush
