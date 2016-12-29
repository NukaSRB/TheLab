<script>
  window.Laravel = <?php echo json_encode([
          'csrfToken'  => csrf_token(),
          'userId'     => auth()->id(),
          'host'       => env('APP_URL'),
          'socketPort' => env('NODE_PORT'),
  ]); ?>
</script>

<!-- javascript-->
{!! HTML::script('js/app.js') !!}

<!-- JS Include -->
@section('jsInclude')
@show
<!-- JS Include Form -->
@section('jsIncludeForm')
@show

<script>
  $(document).ready(function ()
  {
    @if (session()->has('errors'))
    var errors = "There was a problem with your request.<br />"+{!! is_string(session()->get('errors')) ? '"'. session()->get('errors') .'"' : json_encode(implode('<br />', is_array(session()->get('errors')) ? session()->get('errors') : session()->get('errors')->all())) !!};
    @else
    var errors = 0;
    @endif

    var mainError   = {!! (session()->has('error') ? json_encode(session()->get('error')) : 0) !!};
    var mainErrors  = errors;
    var mainMessage = {!! (session()->has('message') ? json_encode(session()->get('message')) : 0) !!};
    var mainWarning = {!! (session()->has('warning') ? json_encode(session()->get('warning')) : 0) !!};

    // On Ready Js
    @section('onReadyJs')
    @show
    // On Ready Js Form
    @section('onReadyJsForm')
    @show
  });
</script>

<!-- JS -->
@section('js')
@show
<!-- JS Form -->
@section('jsForm')
@show
