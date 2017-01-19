<table class="table">
  <thead>
    <tr>
      <th class="search-box">
        <p class="control"><input type="text" class="input flex" placeholder="Search employees" /></p>
      </th>
      @foreach ($availableDays->weeks as $week)
        <th class="is-week">
          <strong>{{ $week->name }}</strong>
          <div class="days">
            @foreach ($week->days as $day)
              <div class="is-day">{{ $day->day }}</div>
            @endforeach
          </div>
        </th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $user)
      <tr>
        <td class="user">{{ $user->first_name }} {{ $user->last_name }}</td>
        @foreach ($availableDays->weeks as $week)
          <td class="is-week">
            <div class="days">
              @foreach ($week->days as $day)
                <div class="is-day">
                  {{ $user->schedule->weeks->get($week->weekOfYear)->dailyTotal->get($day->date) }}
                </div>
              @endforeach
            </div>
          </td>
        @endforeach
      </tr>
      @foreach ($user->projects as $project)
        <tr>
          <td class="project">
            <small>{{ $project->client->label }}</small>
            <br />
            <strong>{{ $project->label }}</strong>
          </td>
          @foreach ($user->schedule->weeks as $week)
            <td class="is-week">
              <div class="days">
                @foreach ($week->days as $day)
                  <div class="is-day">
                    {{ $day->schedule->getWhereFirst('project_id', $project->id)->hours or 'Open' }}
                  </div>
                @endforeach
              </div>
            </td>
          @endforeach
        </tr>
      @endforeach
    @endforeach
  </tbody>
</table>
@section('css')
  <style>
    .search-box {
      flex:         1;
      border-top:   1px solid lightGrey;
      border-right: 1px solid lightGrey;
      padding:      0 !important;
    }

    .search-box .input {
      height:       50px;
      border:       none;
      border-right: 1px solid lightGrey !important;
    }

    .is-week {
      flex:         1;
      text-align:   center !important;
      border-right: 1px solid lightGrey;
      padding:      0 !important;
      height:       42px;
    }

    .schedule-row.header .is-week {
      border-top: 2px solid purple;
    }

    .is-week .days {
      display:        flex;
      flex-direction: row;
    }

    .user {
      padding:      0 10px 0 0 !important;
      border-right: 1px solid lightGrey !important;
    }

    .project {
      text-align:   right;
      padding:      0 10px 0 0 !important;
      border-right: 1px solid lightGrey !important;
    }

    .is-day {
      flex:         1;
      border-right: 1px solid lightGrey;
      text-align:   center;
    }

    th.is-week .is-day {
      height: 28px;
    }

    td.is-week .is-day {
      height: 42px;
    }
  </style>
@endsection
