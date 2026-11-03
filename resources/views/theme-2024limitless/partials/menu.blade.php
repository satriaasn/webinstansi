@if ($menu->children->count() > 0)
    <li class="nav-item dropdown">
        <a class="navbar-nav-link dropdown-toggle font-weight-bold" href="{{ $menu->url }}" data-toggle="dropdown" data-hover="dropdown">
            {{ $menu->name }}
        </a>
        <div class="dropdown-menu">
            @foreach ($menu->children as $children)
                @include(getTheme('partials.menus_child'))
            @endforeach
        </div>
    </li>
@else
    <li class="nav-item">
        <a class="navbar-nav-link font-weight-bold {{ Request::is($menu->url) ? 'active' : ($menu->id == 1 && Request::is('/') ? 'active' : '') }}"
           aria-current="page" href="{{ url($menu->url) }}">
            {{ $menu->name }}
        </a>
    </li>
@endif
