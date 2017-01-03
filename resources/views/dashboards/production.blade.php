{{--<div class="columns">--}}
  {{--<div class="column is-three-quarters">--}}
    {{--@include('dashboards.partials.events')--}}
    {{--@include('dashboards.partials.tasks')--}}
  {{--</div>--}}
  {{--<div class="column is-one-quarter">--}}
    {{--@include('dashboards.partials.current-task')--}}
    {{--@include('dashboards.partials.daily-schedule')--}}
    {{--@include('dashboards.partials.weekly-schedule')--}}
  {{--</div>--}}
{{--</div>--}}
<production-dashboard></production-dashboard>
@section('css')
  <style>
    @foreach ($weeklySchedule as $schedule)
    .{{ $schedule->client->name }}::-webkit-progress-value {
      background-color: #{{ $schedule->client->color }};
    }
    @endforeach
  </style>
@endsection
