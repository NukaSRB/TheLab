@if ((Menu::exists('breadcrumbs') && Menu::hasLinks('breadcrumbs')) || (Menu::exists('quickLinks') && Menu::hasLinks('quickLinks')))
  <div class="level breadcrumbs grey-lighter">
    @if (Menu::exists('breadcrumbs') && Menu::hasLinks('breadcrumbs'))
      <div class="level-left">
        @foreach (Menu::render('breadcrumbs')->links as $item)
          @if ($loop->last)
            <div class="level-item active">{{ $item->name }}</div>
          @else
            <div class="level-item"><a href="{{ $item->url }}">{{ $item->name }}</a></div>
          @endif
        @endforeach
      </div>
    @endif
    @if (Menu::exists('quickLinks') && Menu::hasLinks('quickLinks'))
      <div class="level-right">
        @foreach (Menu::render('quickLinks')->links as $item)
          <div class="level-item"><a href="{{ $item->url }}">{{ $item->name }}</a></div>
        @endforeach
      </div>
    @endif
  </div>
@endif
