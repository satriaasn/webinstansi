@if((count($menu->children) > 0) && ($menu->parent_id == 0))
    <a href="javascript:void(0);" class="navbar-nav-link"
       data-toggle="dropdown" data-hover="dropdown">{!! $menu->name !!}</a>
@else

    @if($menu->target == 'none')
        <a href="{{ url($menu->url) }}"
           class="navbar-nav-link {{count($menu->children) > 0 ? 'dropdown-toggle' : ''}}">{!! $menu->name !!}</a>
    @else
        <a href="{{ $menu->url }}" target="_blank"
           class="navbar-nav-link {{count($menu->children) > 0 ? 'dropdown-toggle' : ''}}">{!! $menu->name !!}</a>
    @endif
@endif

@if (count($menu->children) > 0)
    <div class="dropdown-submenu">
        @foreach($menu->children as $menu)
            @include(getTheme('partials.menu_awal'), $menu)
        @endforeach
    </div>
@endif
