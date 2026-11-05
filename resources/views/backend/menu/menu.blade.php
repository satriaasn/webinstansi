@php
    $hasChildren = count($menu->children) > 0;
    $isChild = $menu->parent_id > 0;
@endphp
<li data-id="{{ $menu->id }}" class="dd-item dd3-item">
    <div class="dd-handle dd3-handle" title="Tahan dan geser untuk memindahkan urutan atau membuat hierarki submenu">
        <i class="fas fa-grip-vertical text-slate-400 pointer-events-none"></i>
    </div>
    <div class="dd3-content">
        <div class="flex items-center gap-2 flex-wrap min-w-0 pr-2">
            <!-- Dynamic Hierarchy Badge -->
            <div class="menu-level-badge flex-shrink-0">
                @if($isChild)
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 flex-shrink-0">
                        <i class="fas fa-turn-up rotate-90 text-[8px]"></i> Submenu
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-[10px] font-extrabold px-2 py-0.5 rounded-md bg-blue-50 text-[#1A56DB] border border-blue-200 uppercase tracking-wider flex-shrink-0">
                        <i class="fas fa-layer-group text-[8px]"></i> Menu Utama
                    </span>
                @endif
            </div>

            <span class="font-bold text-xs sm:text-sm text-slate-800">
                {{ $menu->name }}
            </span>

            <span class="text-[11px] font-medium text-slate-400 bg-slate-50 border border-slate-200/80 px-2 py-0.5 rounded-md truncate max-w-xs" title="{{ $menu->url }}">
                <i class="fas fa-link text-[9px] text-slate-400 mr-1"></i>{{ $menu->url }}
            </span>

            @if($menu->target == '_blank')
                <span class="text-[10px] text-slate-400" title="Buka di tab baru">
                    <i class="fas fa-arrow-up-right-from-square text-[9px]"></i>
                </span>
            @endif
        </div>

        <div class="pull-right">
            <!-- Quick Hierarchy Action Buttons -->
            <div class="inline-flex items-center bg-slate-100 rounded-lg p-0.5 border border-slate-200 mr-1.5">
                <button type="button" class="btn-hierarchy btn-outdent" title="Geser Keluar (Jadikan Menu Induk / Kurangi Level)">
                    <i class="fas fa-arrow-left text-[9px]"></i>
                </button>
                <button type="button" class="btn-hierarchy btn-indent" title="Geser Masuk (Jadikan Submenu dari menu di atasnya)">
                    <i class="fas fa-arrow-right text-[9px]"></i>
                </button>
                <button type="button" class="btn-hierarchy btn-moveup" title="Pindah Urutan ke Atas">
                    <i class="fas fa-arrow-up text-[9px]"></i>
                </button>
                <button type="button" class="btn-hierarchy btn-movedown" title="Pindah Urutan ke Bawah">
                    <i class="fas fa-arrow-down text-[9px]"></i>
                </button>
            </div>

            <!-- Edit & Delete Buttons -->
            <a href="{{ url('dashboard/menu/'.Hashids::encode($menu->id).'/edit') }}"
               class="btn btn-primary btn-sm btn-xss" title="Edit Menu">
                <i class="fa fa-pencil text-[11px]"></i>
            </a>
            <a href="{{ url('dashboard/menu/'.Hashids::encode($menu->id)) }}" 
               class="btn btn-danger btn-sm btn-xss"
               data-delete="" title="Hapus Menu">
                <i class="fa fa-trash text-[11px]"></i>
            </a>
        </div>
    </div>

    @if ($hasChildren)
        <ol class="dd-list">
            @foreach($menu->children as $child)
                @include('backend.menu.menu', ['menu' => $child])
            @endforeach
        </ol>
    @endif
</li>
