<nav class="nav primary">
  <div class="nav-left">
    <div class="nav-item">
      <a class="is-brand" href="{!! route('home') !!}">The Lab</a>
    </div>
    @if (Menu::exists('leftMenu') && Menu::hasLinks('leftMenu'))
      @each('layouts.menus.bulma.menu', Menu::render('leftMenu')->links, 'item')
    @endif
  </div>
  <div class="nav-right">
    @if (Menu::exists('rightMenu') && Menu::hasLinks('rightMenu'))
      @each('layouts.menus.bulma.right-menu', Menu::render('rightMenu')->links, 'item')
    @endif
  </div>
</nav>
<br style="clear: both;" />
