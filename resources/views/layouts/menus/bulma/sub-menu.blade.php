@if ($item->isDropDown() && $item->hasLinks())
  <div class="nav-item dropdown {{ $item->active ? 'is-active' : '' }}">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $item->name }}<b class="caret"></b></a>
    <ul class="dropdown-menu">
      @each('layouts.menus.bulma.sub-menu', $item->links, 'item')
    </ul>
  </div>
@else
  <li>
    @if ($item->getOption('text') == true)
      <p class="navbar-text">{!! $item->name !!}</p>
    @else
      {!! HTML::link($item->url, $item->name, $item->options + ['class' => $item->active ? 'nav-item is-active' : 'nav-item']) !!}
    @endif
  </li>
@endif
