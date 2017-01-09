<production-dashboard></production-dashboard>
@section('css')
  <style>
    @foreach ($weeklySchedule as $schedule)
    .{{ $schedule['project']['name'] }}::-webkit-progress-value {
      background-color: #{{ $schedule['project']['color'] }};
    }
    @endforeach
  </style>
@endsection
