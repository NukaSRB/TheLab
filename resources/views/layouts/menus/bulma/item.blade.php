<div class="nav-item {{ $item->active ? 'is-active' : '' }}">
  @if ($item->getOption('text') == true)
    <p class="navbar-text">{!! $item->name !!}</p>
  @else
    {!! HTML::link($item->url, $item->name, $item->options + ['class' => 'nav-link']) !!}
  @endif
</div>
