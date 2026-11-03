@if ((count($menu->children) > 0) && ($menu->parent_id > 0))
    <li data-id="{{ $menu->id }}" class="dd-item dd3-item">
        <div class="dd-handle dd3-handle"></div>
        <div class="dd3-content">
            {{ $menu->name }} - {{ $menu->url }}
            <div class='pull-right'>
                <a href="{{ url('dashboard/menu/'.Hashids::encode($menu->id).'/edit') }}"
                   class="btn btn-primary btn-sm btn-xss" title="Edit Menu"><span class="fa fa-pencil"
                                                                                  aria-hidden="true"/></a>
                <a href="{{ url('dashboard/menu/'.Hashids::encode($menu->id)) }}" class="btn btn-danger btn-sm btn-xss"
                   data-delete=""><span class="fa fa-trash" aria-hidden="true" title="Delete Menu"></span></a>
            </div>
        </div>
@else
    <li data-id="{{ $menu->id }}" class="dd-item dd3-item">
        <div class="dd-handle dd3-handle"></div>
        <div class="dd3-content">
            {{ $menu->name }} - {{ $menu->url }}
            <div class='pull-right'>
                <a href="{{ url('dashboard/menu/'.Hashids::encode($menu->id).'/edit') }}"
                   class="btn btn-primary btn-sm btn-xss" title="Edit Menu"><span class="fa fa-pencil"
                                                                                  aria-hidden="true"/></a>
                <a href="{{ url('dashboard/menu/'.Hashids::encode($menu->id)) }}" class="btn btn-danger btn-sm btn-xss"
                   data-delete=""><span class="fa fa-trash" aria-hidden="true" title="Delete Menu"></span></a>
            </div>
        </div>
        @endif
        @if (count($menu->children) > 0)
            <ol style="" class="dd-list">
                @foreach($menu->children as $menu)
                    @include('backend.menu.menu', $menu)
                @endforeach
            </ol>
        @endif
    </li>
