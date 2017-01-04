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
          @if (isset($content))
            {!! $content !!}
          @else
            @yield('content')
          @endif
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
