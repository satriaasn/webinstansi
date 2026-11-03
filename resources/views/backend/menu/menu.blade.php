@php
    $hasChildren = count($menu->children) > 0;
    $isChild = $menu->parent_id > 0;
@endphp
<li data-id="{{ $menu->id }}" class="dd-item dd3-item {{ $hasChildren ? 'has-children' : '' }}">
    <div class="dd-handle dd3-handle" title="Tahan dan geser untuk memindahkan posisi urutan menu"></div>
    <div class="dd3-content">
        <div class="flex items-center gap-2 flex-wrap min-w-0 pr-2">
            @if($isChild)
                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 flex-shrink-0">
                    <i class="fas fa-turn-up rotate-90 text-[8px]"></i> Submenu
                </span>
            @else
                <span class="inline-flex items-center gap-1 text-[10px] font-extrabold px-2 py-0.5 rounded-md bg-blue-50 text-[#1A56DB] border border-blue-200 uppercase tracking-wider flex-shrink-0">
                    <i class="fas fa-layer-group text-[8px]"></i> Menu Utama
                </span>
            @endif

            <span class="font-bold text-xs sm:text-sm text-slate-800">
                {{ $menu->name }}
            </span>

            <span class="text-[11px] font-medium text-slate-400 bg-slate-50 border border-slate-200/80 px-2 py-0.5 rounded-md truncate max-w-xs" title="{{ $menu->url }}">
                <i class="fas fa-link text-[9px] text-slate-400 mr-1"></i>{{ $menu->url }}
            </span>
        </div>

        <div class="pull-right">
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
