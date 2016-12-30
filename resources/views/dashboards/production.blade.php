<div class="columns">
  <div class="column is-three-quarters">
    @include('dashboards.partials.events')
    @include('dashboards.partials.tasks')
  </div>
  <div class="column is-one-quarter">
    @include('dashboards.partials.current-task')
    @include('dashboards.partials.daily-schedule')
    @include('dashboards.partials.weekly-schedule')
  </div>
</div>
@section('css')
  <style>
    @foreach ($weeklySchedule as $schedule)
    .{{ $schedule->client->name }}::-webkit-progress-value {
      background-color: #{{ $schedule->client->color }};
    }
    @endforeach
  </style>
@endsection
<script>
  @section('onReadyJs')
    upTime('{{ $timer['start'] }}');
  @endsection
</script>
@section('js')
  <script>
    function upTime(countTo)
    {
      now        = new Date();
      countTo    = new Date(countTo);
      difference = (now - countTo);

      hours = Math.floor((difference % (60 * 60 * 1000 * 24)) / (60 * 60 * 1000) * 1);
      mins  = Math.floor(((difference % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) / (60 * 1000) * 1);
      secs  = Math.floor((((difference % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) % (60 * 1000)) / 1000 * 1);

      document.getElementById('hours').firstChild.nodeValue   = pad(hours, 1);
      document.getElementById('minutes').firstChild.nodeValue = pad(mins, 2);
      document.getElementById('seconds').firstChild.nodeValue = pad(secs, 2);

      clearTimeout(upTime.to);
      upTime.to = setTimeout(function () { upTime(countTo); }, 1000);
    }

    function pad(n, width, z)
    {
      z = z || '0';
      n = n + '';
      return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
    }
  </script>
@endsection
