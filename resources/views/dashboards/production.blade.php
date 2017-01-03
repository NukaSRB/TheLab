<production-dashboard></production-dashboard>
@section('css')
  <style>
    @foreach ($weeklySchedule as $schedule)
    .{{ $schedule['client']['name'] }}::-webkit-progress-value {
      background-color: #{{ $schedule['client']['color'] }};
    }
    @endforeach
  </style>
@endsection
