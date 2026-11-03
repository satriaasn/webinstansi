@if ($child->children->count() > 0)


<div class="dropdown-submenu">
    <a href="#" class="dropdown-item dropdown-toggle">

        {{ $child->name }}
    </a>
    <div class="dropdown-menu">
        @foreach ($child->children as $children)
        @include(getTheme('partials.menus_child'))
        @endforeach
    </div>
</div>

@else
<a class="dropdown-item mb-1" href="{{ url($child->url) }}">
    {{ $child->name }}
</a>
@endif