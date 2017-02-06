{{--<user-schedule></user-schedule>--}}
@extends('backpack::layout')

@section('content')
  <table class="table">
    <thead>
      <tr>
        <th class="search-box">
          <input type="text" class="form-control flex" placeholder="Search employees" />
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
          <td class="user">
            <img src="{{ Gravatar::exists($user->username) ? Gravatar::get($user->username) : 'https://placehold.it/40/3c334a/ffffff/&text='. ucfirst(substr($user->first_name, 0, 1).substr($user->last_name, 0, 1)) }}" style="width: 40px;" alt="">
            <a data-toggle="collapse" href="#collapse{{ $user->id }}" aria-expanded="false" aria-controls="collapse{{ $user->id }}">
              {{ $user->first_name }} {{ $user->last_name }}
            </a>
          </td>
          @foreach ($availableDays->weeks as $week)
            <td class="is-week">
              <a class="days" href="/admin/schedule/edit/{{ $user->id }}/{{ $week->days->first()->date }}">
                @php($previous = 9999)
                @foreach ($week->days as $day)
                  @php($dayTotal = $user->schedule->weeks->get($week->weekOfYear)->dailyTotal->get($day->date))

                  @if ($previous != $dayTotal['total'])
                    <div class="is-day {{ $dayTotal['class'] }}">{{ $dayTotal['display'] }}</div>
                  @else
                    <div class="is-day {{ $dayTotal['class'] }}">&nbsp;</div>
                  @endif
                  @php($previous = $dayTotal['total'])
                @endforeach
              </a>
            </td>
          @endforeach
        </tr>
    </tbody>
    <tbody class="collapse project-drawer" id="collapse{{ $user->id }}">
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
                  @php($hours = is_null($day->schedule->getWhereFirst('project_id', $project->id)) ? null : $day->schedule->getWhereFirst('project_id', $project->id)->hours)
                  @php($notes = is_null($day->schedule->getWhereFirst('project_id', $project->id)) ? null : $day->schedule->getWhereFirst('project_id', $project->id)->note)
                  <div class="is-day {{ ! is_null($hours) ? 'with-hours' : null }}">
                    <div title="{{ $notes }}">
                      @if (! is_null($notes))
                        <i class="fa fa-fw fa-sticky-note"></i>
                      @endif
                      {{ $hours }}
                    </div>
                  </div>
                @endforeach
              </div>
            </td>
          @endforeach
        </tr>
      @endforeach
    </tbody>
    @endforeach
  </table>

  <style>
    .search-box {
      flex:         1;
      border-top:   1px solid lightGrey;
      border-right: 1px solid lightGrey;
      padding:      0 !important;
    }

    .search-box .form-control {
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

    .project-drawer {
      background-color: #222d32;
      color:            #eee;
    }

    .project-drawer td {
      border: 1px solid #000000 !important;
    }

    .project-drawer .is-day {
      border-right: 1px solid #000000 !important;
    }

    .is-day {
      flex:         1;
      border-right: 1px solid lightGrey;
      text-align:   center;
    }

    .is-day.is-full {
      padding-top:        10px;
      background-color:   #3c334a;
      border-right-color: #3c334a;
      color:              #ffffff;
    }

    .is-day.is-over {
      padding-top:        10px;
      background-color:   #7c5156;
      border-right-color: #7c5156;
      color:              #ffffff;
    }

    .is-day.is-under {
      padding-top:        10px;
      background-color:   #9592a0;
      border-right-color: #9592a0;
      color:              #ffffff;
    }

    .with-hours {
      border-radius:    5px;
      background-color: #3c334a;
    }

    .with-hours div {
      padding-top: 12px;
    }

    th.is-week .is-day {
      height: 28px;
    }

    td.is-week .is-day {
      height: 42px;
    }
  </style>
@endsection
