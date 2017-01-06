<!doctype html>
<html>
  <head>
    @include('layouts.partials.header')
  </head>

  <body>
    <div id="app">
      <div class="container-fluid" id="container">
        @include('layouts.partials.menu')
        @include('layouts.partials.breadcrumbs')

        <div id="content">
          <aside class="menu app-sidebar animated grey text-white">
            <p class="menu-label text-white">
              Clients
            </p>
            <ul class="menu-list">
              @foreach(\Menu::render('adminMenu')->links as $link)
              <li>
                <a href="{{ $link->url }}" {{ $link->active ? 'class=is-active' : null }}>
                  <span>{{ $link->name }}</span>
                </a>
              </li>
              @endforeach
            </ul>
          </aside>
          <section class="app-main">
            @if (isset($content))
              {!! $content !!}
            @else
              @yield('content')
            @endif
          </section>
        </div>

        @section('footer')
          @include('layouts.partials.footer')
        @show
      </div>

      @include('layouts.partials.modals')

    </div>
    @include('layouts.partials.javascript')
  </body>
</html>
