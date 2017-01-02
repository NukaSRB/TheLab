@if ($item->isDropDown() && $item->hasLinks())
  <div class="nav-item dropdown {{ $item->active ? 'is-active' : '' }}">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ $item->name }}<b class="caret"></b></a>
    <ul class="dropdown-menu is-right-aligned">
      @each('layouts.menus.bulma.sub-menu', $item->links, 'item')
    </ul>
  </div>
@else
  @include('layouts.menus.bulma.item')
@endif
